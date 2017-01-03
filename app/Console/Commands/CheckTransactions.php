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

class CheckTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckTransactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check any donation transactions due';

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

        $this->campaigns = Campaign::where('status', 'blocked')->where('current_funds', '>', 0)->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info(count($this->campaigns) . " campaigns to check");
        foreach ($this->campaigns as $campaign) {
            //Check if the campaign has any funds and if there is any transaction of it. If there is no transaction,
            //it means that we should transfer all donations to next campaign if available

            if ($campaign->current_funds > 0) {
                $transactions = Transaction::where('from_campaign_id', $campaign->id)->get();
                if ($transactions->count()) {
                    continue;
                }
            }

            //all the donations that need to be moved to next campaign
            $donations = Donation::where('campaign_id', $campaign->id)->get();
            $this->info("Processing campaign " . $campaign->id);
            $this->info("Campaign id " . $campaign->id . " has: " . $campaign->current_funds . ' from ' . count($donations) . ' donations');

            //Lets see if there is another active campaign with same classification code
            $nextCampaign = Campaign::where('classification_code', $campaign->classification_code)
                ->where('status', 'active')->orderBy('created_at', 'asc')->get()->first();

            if ($nextCampaign) {
                $this->info("Found appropriate campaign to transfer with id " . $nextCampaign->id);
                //there is an appropriate campaign, lets move the funds donation by donation
                foreach ($donations as $d) {
                    //Mark transaction
                    DB::transaction(function () use ($d, $nextCampaign) {
                        $transaction = Transaction::create([

                            'from_donation_id' => $d->id,
                            'amount' => $d->amount,
                            'goods' => $d->goods,
                            'time' => date("Y-m-d H:i:s"),
                            'description' => 'Automatic - system',
                            'from_campaign_id' => $d->campaign_id,
                            'to_campaign_id' => $nextCampaign->id
                        ]);
                        $this->info('Transaction logged under ID ' . $transaction->id);


                        $this->info('Transferring donation ID ' . $d->id . ' with amount of ' . $d->amount);
                        $newDonation = $d->replicate();
                        $newDonation->created_at = date("Y-m-d H:i:s");
                        $newDonation->campaign_id = $nextCampaign->id;
                        $newDonation->transaction_id = $transaction->id;
                        $newDonation->save();
                        $this->info('Saved new donation with ID ' . $newDonation->id);


                        $transaction->to_donation_id = $newDonation->id;
                        $transaction->save();
                    }, 2);


                }
            }


            $this->info("\n --------------------------------------------------------- \n");


        }
    }
}
