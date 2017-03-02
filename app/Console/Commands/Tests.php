<?php

namespace App\Console\Commands;

use App\Models\BankTransfersDatum;
use App\Models\Beneficiary;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Donor;
use App\Models\MonetaryInput;
use App\Models\MonetaryOutput;
use App\Models\MonetaryOutputSource;
use App\Models\Order;
use App\Models\PaymentProviderDatum;
use App\Models\Transaction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Tests extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Tests {--donation : Test input of new donation} { --take-money : Test taking of money}
    {--finalize : Test final steps of campaign}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test how app reacts to different inputs';


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();


    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $donation = $this->option('donation');
        $takeMoney = $this->option('take-money');
        $finalizing = $this->option('finalize');


        if (env('APP_ENV') != 'development') {
            $this->info('App is not in development mode: ABORTING command');
        }

        $donorsRes = Donor::take(15)->get();
        $donors = [];
        foreach ($donorsRes as $key => $d) {
            if (isset($d->entity)) {
                $donor_name = $d->entity->name;
            } else {
                $donor_name = $d->person->first_name . ' ' . $d->person->last_name;
            }

            $donors[] = $d->id . ':' . $donor_name;
        }
        if (!count($donors)) {
            $this->error('No usable donors in DB. Aborting!');
            dd();
        }

        $donor_index = $this->choice('Please select a donor from the list', $donors);
        $donor_id = explode(':', $donor_index)[0];
        $donor = Donor::find($donor_id);
        dd($donor->recalculateDiversityScore());


        $campaignsRes = Campaign::whereIn('status', ['active', 'target_reached'])->get();
        $campaigns = [];
        foreach ($campaignsRes as $key => $c) {
            $campaign_name = $c->status == 'active' ? $c->name : $c->name . ' (target reached)';

            $campaigns[] = $c->id . ':' . $campaign_name;
        }
        if (!count($campaigns)) {
            $this->error('No usable campaigns in DB. Aborting!');
            dd();
        }
        $campaign_index = $this->choice('Please select a campaign from the list', $campaigns);
        $campaign_id = explode(':', $campaign_index)[0];


        $amount = $this->ask('Enter desired amount to donate');

        $payment_type = $this->choice('Please select a payment type', ['bank', 'card']);


        if ($this->confirm('Are you sure you want to donate ' . $amount . ' to campaign id ' . $campaign_id . ' in the name of user id ' . $donor_id . ' paying with ' . $payment_type)) {
            $this->info('Creating order');

            $order = new Order();
            $order->donor_id = $donor_id;
            $order->donations = serialize([[
                'campaign' => $campaign_id,
                'type' => 'single',
                'amount' => $amount,
            ]]);
            $order->amount = $amount;
            $order->order_token = Str::random(60);
            $order->type = 'single';
            $order->reference = strtoupper(str_random(4) . '-' . str_random(4)) . '0';
            $order->payment_method = $payment_type == 'bank' ? 'bank_transfer' : 'credit_card';
            $order->user_ip = '127.0.0.1';
            try {
                $order->save();
                $this->info('Order created');

            } catch (\Exception $e) {
                $this->error('Creating order entry failed with message: ' . $e->getMessage() . ' on line ' . $e->getLine());
                dd();
            }

            if ($payment_type == 'bank') {
                $this->info('Creating bank transfer data');
                $paymentData = [
                    "bank_id" => 3,
                    "payee_name" => explode(':', $donor_index)[1] . '_TEST',
                    "payee_account" => 'Test fake iban',
                    "donor_id" => $donor_id,
                    'order_id' => $order->id,
                    "time" => date('Y-m-d H:i:s', strtotime('now')),
                    "amount" => $amount,
                    "reference" => $order->reference
                ];

                try {
                    $transfer = BankTransfersDatum::create($paymentData);
                    $this->info('Bank transfer entry created');
                } catch (\Exception $e) {
                    $this->error('Creating bank transfer entry failed with message: ' . $e->getMessage() . ' on line ' . $e->getLine());
                    dd();

                }
            } else {
                $this->info('Creating payment provider data');

                $fields = [
                    'order_id' => $order->id,
                    'order_number' => 'fake_' . $order->id,
                    'transaction_amount' => $amount,
                    'transaction_datetime' => date('Y-m-d H:i:s'),
                    'status' => 'authorized',
                    'response_message' => 'approved',
                    'response_code' => 0,
                    'currency_code' => 191,
                    'card_type' => 'fake_card',
                    'cardholder_name' => 'John',
                    'cardholder_surname' => 'Doe',
                    'cardholder_address' => 'Nowhere',
                    'cardholder_city' => 'Bumville',
                    'cardholder_zip_code' => 24234,
                    'cardholder_email' => 'q@a.com',
                    'cardholder_phone' => 123453251,
                    'cardholder_country' => 'Arizona',
                    'card_details' => '548866xxxxxx5007',
                    'reference_number' => '000000393926',
                    'approval_code' => 342453
                ];

                try {
                    $pData = new PaymentProviderDatum($fields);
                    $pData->save();
                    $this->info('Payment provider data entry created');
                } catch (\Exception $e) {
                    $this->error('Creating provider data entry failed with message: ' . $e->getMessage() . ' on line ' . $e->getLine());
                    dd();

                }

            }


            $this->info('Creating monetary input');
            $inputData = [
                'donor_id' => $donor_id,
                'amount' => $amount,
                'order_id' => $order->id,
                'payment_provider_data_id' => isset($pData) ? $pData->id : null,
                'bank_transfer_data_id' => isset($pData) ? null : $transfer->id,
            ];
            try {
                $mInput = MonetaryInput::create($inputData);
                $this->info('Monetary input data entry created');
            } catch (\Exception $e) {
                $this->error('Creating monetary input entry failed with message: ' . $e->getMessage() . ' on line ' . $e->getLine() . ' file ' . $e->getFile());
                dd();

            }
            $this->info('Tests completed');
        }


    }

}
