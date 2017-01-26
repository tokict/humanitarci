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
     * Chech the campaigns and do automated tasks on them like change statuses etc
     *
     * @return mixed
     */
    public function handle()
    {
        foreach ($this->campaigns as $campaign) {
            //Close the ones with past date that are active
            if (strtotime($campaign->ends) >= time()) {
                if (in_array($campaign->status, ['active'])) {
                    if ($campaign->target_amount) {
                        //Failed because we had a target to reach and didn't
                        //We would be in target_reached if we did and this is why we don't check for amount. Its implied
                        $campaign->status = 'failed';

                    } else {
                        //Succeeded because the campaign had no target to fail
                        $campaign->status = 'succeeded';
                    }
                }
            }

            //Start the ones with past date
            if (strtotime($campaign->starts) >= time()) {
                if ($campaign->status == 'inactive') {
                    $campaign->status = 'active';
                }

            }


            $campaign->save();
        }

    }
}
