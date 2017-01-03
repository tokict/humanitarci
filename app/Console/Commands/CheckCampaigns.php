<?php

namespace App\Console\Commands;

use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryInput;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CheckCampaigns extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckCampaigns';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check campaigns for automatic data manipulation';

    /**
     * orders.
     *
     * @var string
     */
    protected $campaigns;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->campaigns = Campaign::where('status', '!=', 'finalized')->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        foreach ($this->campaigns as $campaign) {
            //Close the ones with past date
            if(strtotime($campaign->ends) >= time()){
                //If its not succeeded already, it means we didn't reach the amount
                if($campaign->status != 'succeeded') {
                    $campaign->status = 'failed';
                }

            }

            //Start the ones with past date
            if(strtotime($campaign->starts) >= time()){
                if($campaign->status == 'inactive') {
                    $campaign->status = 'active';
                }

            }

        }

        $campaign->save();

    }
}
