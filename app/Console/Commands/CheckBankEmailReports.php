<?php

namespace App\Console\Commands;

use App\Models\BankTransfersDatum;
use App\Models\Media;
use App\Models\MonetaryInput;
use App\Models\Order;
use App\Models\Organization;
use Carbon\Carbon;
use Ddeboer\Imap\Search\Email\FromAddress;
use Ddeboer\Imap\SearchExpression;
use Ddeboer\Imap\Server;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        foreach ($this->organizations as $organization) {
            $server = new Server($organization->mail_report_server, $organization->mail_report_port);
            $connection = $server->authenticate($organization->mail_report_username, $organization->mail_report_password);

            $mailbox = $connection->getMailbox('INBOX');
            $search = new SearchExpression();
            $search->addCondition(new FromAddress($organization->mail_report_from));
            $messages = $mailbox->getMessages($search);

            foreach ($messages as $key =>  $message) {
                if($key == 0){
                    continue;
                }
                // $message is instance of \Ddeboer\Imap\Message
                $attachments = $message->getAttachments();

                foreach ($attachments as $attachment) {
                    // $attachment is instance of \Ddeboer\Imap\Message\Attachment
                    // getDecodedContent() decodes the attachment’s contents automatically:

                    file_put_contents('storage/app/temp/' . $attachment->getFilename(), $attachment->getDecodedContent());

                    //Parses doc and returns array of payments to account in form
                    $classname = 'App\Libraries\BankReportParsers\\' . $organization->legalEntity->bank->swift_code;
                    $inputs = new $classname('storage/app/temp/' . $attachment->getFilename());
                    $received = array_merge($received, $inputs->getData());


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

                    //Search for references and assign order_number to each item
                    foreach ($received as $key => $item) {
                        $order = Order::where('reference' ,  trim($item['description']))->orderBy('created_at', 'desc')->get()->first();
                        if($order){
                            $donation = unserialize($order->donations);
                            //Replace amount with real received amount
                            $order->amount = (int) str_replace([".", ","], "", $item['amount']);


                            //Create bank transfer record
                            $paymentData = [
                                "bank_id" => $organization->legalEntity->bank_id,
                                "payee_name" => $item['name'],
                                "payee_account" => $item['iban'],
                                "donor_id" => $order->donor_id,
                                'order_id' => $order->id,
                                "time" => date('Y-m-d H:i:s',strtotime($item['date'])),
                                "amount" => $order->amount,
                                "reference" => $item['description']
                            ];


                            $input = BankTransfersDatum::create($paymentData);

                            //Create monetary input
                            $inputData = [
                                'donor_id' => $order->donor_id,
                                'amount' => $order->amount,
                                'order_id' => $order->id,
                                'bank_transfer_data_id' => $input['id']
                            ];

                            if(MonetaryInput::create($inputData)){
                                $this->info("Payment entered into the system");
                            }else{
                                $this->info("Payment CANNOT be entered into the system");
                            }

                        }


                    }
                }

            }
        }

        $this->info("\n --------------------------------------------------------- \n");


    }
}
