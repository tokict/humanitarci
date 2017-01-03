<?php

namespace App\Console\Commands;

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

class Reset extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Reset';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset db for new round of testing';




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

        if(env('APP_ENV') != 'development'){
            $this->info('App is not in developement mode: ABORTING command');
        }

        DB::statement("SET foreign_key_checks=0");

        MonetaryOutputSource::truncate();
        MonetaryOutput::truncate();
        Order::truncate();
        Donation::truncate();
        PaymentProviderDatum::truncate();
        Transaction::truncate();
        DB::statement("SET foreign_key_checks=1");

        Donor::whereNotNull('amount_donated')->orWhere('amount_donated', 0)->update(
            [
                'amount_donated'=> 0,
                'total_donations' => 0,
                'services_donated' => 0,
                'goods_donated' => 0,
            ]);

        Campaign::whereNotNull('current_funds')->orWhere('current_funds', 0)->update(
            [
                'current_funds'=> 0,
                'donors_number' => 0,
                'percent_done' => 0,
                'funds_transferred_amount' => 0,
            ]);

        Beneficiary::whereNotNull('funds_used')->orWhere('funds_used', 0)->update(
            [
                'funds_used'=> 0,
                'donor_number' => 0
            ]);


        $this->info('Data is reset!');

    }

}
