<?php

namespace App\Console\Commands;

use App\Models\BankReport;
use App\Models\BankTransfersDatum;
use App\Models\MonetaryInput;
use App\Models\Order;
use App\Models\Organization;
use Carbon\Carbon;
use Ddeboer\Imap\Search\Email\FromAddress;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;
use Illuminate\Console\Command;

class CheckBankEmailReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckBankEmailReports';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check mail folder for received reports from the banks';

    /**
     * orders.
     *
     * @var string
     */
    protected $accounts;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->organizations = Organization::with('Campaigns')->whereHas('Campaigns', function ($q) {
            $q->where('ends', '>', Carbon::parse('now')->subDays(7)->toDateString());
        })->get();

    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Checking mail reports from banks");
        $received = [];
        if (!count($this->organizations)) {
            $this->info("No active campaigns");
        }
        foreach ($this->organizations as $organization) {
            if (!$organization->mail_report_username) {
                continue;
            }
            $this->info("#################################################################################");
            $this->info('Processing mails from "' . $organization->name . '"');
            $server = new Server($organization->mail_report_server, $organization->mail_report_port);

            try {
                $connection = $server->authenticate($organization->mail_report_username,
                    $organization->mail_report_password);
                $this->info('Connection successful');


                $mailbox = $connection->getMailbox('INBOX');
                $search = new SearchExpression();
                $search->addCondition(new FromAddress($organization->mail_report_from));
                $messages = $mailbox->getMessages($search);

                foreach ($messages as $key => $message) {
                    //Skip messages received before last task run
                    $receivedAt = Carbon::instance($message->getDate());
                    $last = new Carbon('2 days ago');

                    if ($receivedAt < $last) {
                        continue;
                    }

                    $this->info("************************************************");

                    // $message is instance of \Ddeboer\Imap\Message
                    $attachments = $message->getAttachments();
                    $this->info('Message ' . ($key + 1) . ' has ' . count($attachments) . ' attachments');
                    foreach ($attachments as $key => $attachment) {
                        $exists = BankReport::where('filename', $attachment->getFilename())->get()->first();
                        if($exists){
                            $this->info("Attachment ".$attachment->getFilename()." already processed. Skipping!");
                            continue;
                        }
                        $this->info("!!!!!!!!!!!");
                        $this->info('Processing attachment nr ' . ($key + 1) . '(' . $attachment->getFilename() . ') using class ' . $organization->legalEntity->bank->swift_code);
                        // $attachment is instance of \Ddeboer\Imap\Message\Attachment
                        // getDecodedContent() decodes the attachment’s contents automatically:

                        file_put_contents('storage/app/temp/' . $attachment->getFilename(),
                            $attachment->getDecodedContent());

                        //Parses doc and returns array of payments to account in form
                        $classname = 'App\Libraries\BankReportParsers\\' . $organization->legalEntity->bank->swift_code;
                        try {
                            $inputs = new $classname('storage/app/temp/' . $attachment->getFilename());
                            foreach ($inputs->getData() as $item) {
                                $received[] = $item;
                            };

                        } catch (\Exception $e) {
                            $this->info('Processing of attachment nr ' . ($key + 1) . ' failed with message: ' . $e->getMessage());
                            $received = [];
                        }

                        $this->info("Attachment has " . count($received) . ' payments');


                        /*$media = new Media([]);
                        $s3 = \Storage::cloud('s3');
                        $name = time() . rand(1, 9999) . "." . $organization->mail_report_file_format;
                        if ($s3->put('bank_daily_reports/' . $organization->id . '/' . $name, $attachment->getDecodedContent(), 'public')
                        ) {

                            $media->setAtt('reference', $name);
                            $media->setAtt('type', 'document');
                            $media->setAtt('directory', 'bank_daily_reports');
                            $media->save();
                        } else {

                            Mail::raw('Failed to import attachment from daily reports for
                            organization ' . $organization->name . ' mail: ' . $message->getSubject() . ', file: ' . $attachment->getFilename(), function ($message) {
                                $message->from(env('MAIL_FROM_ADDRESS'), 'Mailer');

                                $message->to(env('WEBMASTER_MAIL'), 'Webmaster')->subject('Problem processing bank report');
                            });
                            continue;
                        }*/
                        $this->info("Attachment parsed!");
                        BankReport::create([
                            'organization_id' => $organization->id,
                            'bank_id' =>  $organization->legalEntity->bank->id,
                            'filename' => $attachment->getFilename(),
                            'received_at' =>  $receivedAt->format("Y-m-d H:i:s")
                        ]);
                    }
                    $this->info("************************************************");
                }
            } catch (\Exception $e) {
                $this->info($e->getMessage());
            }
            $this->info("#################################################################################");
        }
        //Search for references and assign order_number to each item
        if (count($received)) {
            $this->info('Processing received payments');


            foreach ($received as $key => $item) {
                $this->info("//////");
                $this->info('Processing payment nr ' . ($key + 1) . ' of ' . $item['amount'] . ' and date ' . $item['date']);
                $parts = explode(" ", $item['description']);
                if (count($parts) >= 2) {
                    $item['description'] = $parts[1];
                }

                $item['description'] = rtrim(trim($item['description'], ""), "-");
                //Last number of $desc is index and should not be used to find reference in DB
                $order = Order::where('reference', mb_substr($item['description'], 0, -1))->orderBy('created_at',
                    'desc')->get()->first();
                if ($order) {
                    $this->info('Order for payment ' . ($key + 1) . ' found');

                    //Replace amount with real received amount
                    $order->amount = (int)str_replace([".", ","], "", $item['amount']);

                    $this->info('Amount is ' . $order->amount);
                    //Create bank transfer record
                    $paymentData = [
                        "bank_id" => $organization->legalEntity->bank_id,
                        "payee_name" => $item['name'],
                        "payee_account" => $item['iban'],
                        "donor_id" => $order->donor_id,
                        'order_id' => $order->id,
                        "time" => date('Y-m-d H:i:s', strtotime($item['date'])),
                        "amount" => $order->amount,
                        "reference" => $item['description']
                    ];

                    try {
                        $input = BankTransfersDatum::create($paymentData);
                    } catch (\Exception $e) {
                        $this->info('Creating bank transfer entry failed with message: ' . $e->getMessage());
                        continue;
                    }

                    //Create monetary input
                    $inputData = [
                        'donor_id' => $order->donor_id,
                        'amount' => $order->amount,
                        'order_id' => $order->id,
                        'bank_transfer_data_id' => $input['id']
                    ];

                    if (MonetaryInput::create($inputData)) {
                        $this->info("Payment entered into the system");
                    } else {
                        $this->info("Payment CANNOT be entered into the system");
                    }

                } else {
                    $this->info("No order found for payment! Skipping!");
                }
                $this->info("//////");

            }
        }


        $this->info("\n --------------------------------------------------------- \n");


    }
}
