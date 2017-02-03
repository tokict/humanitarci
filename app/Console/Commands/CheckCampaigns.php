<?php

namespace App\Console\Commands;

use App\Models\ActionLog;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\MonetaryInput;
use App\Models\Order;
use App\Models\Setting;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * @var object
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
        $this->info('Found '.$this->campaigns->count().' non-finalized campaigns in db');
        foreach ($this->campaigns as $campaign) {
            //Close the ones with past date that are active
            if (strtotime($campaign->ends) <= time()) {
                // if the campaign was never active, leave it. Just END those that tried to get funded
                if (in_array($campaign->status, ['active', 'target_reached'])) {
                    if ($campaign->target_amount && $campaign->target_amount > $campaign->current_funds) {
                        $this->info('Marking campaign "'.$campaign->name.'" ID: '.$campaign->id.' as ended');
                        $campaign->status = 'ended';

                    } else {
                        //Succeeded because the campaign had no target to fail
                        $campaign->status = 'succeeded';
                        $this->info('Marking campaign "'.$campaign->name.'" ID: '.$campaign->id.' as succeeded');
                    }
                }
            }

            //Start the ones with past date
            if (strtotime($campaign->starts) <= time() && strtotime($campaign->ends) >= time()) {
                if ($campaign->status == 'inactive') {
                    $campaign->status = 'active';
                    $this->info('Starting campaign "'.$campaign->name.'" ID: '.$campaign->id);
                }

            }


            $campaign->save();
        }

    }
}
