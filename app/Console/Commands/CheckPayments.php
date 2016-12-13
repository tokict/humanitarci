<?php

namespace App\Console\Commands;

use App\Models\MonetaryInput;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'CheckPayments {--single : Command is to be run just once}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync payments with payment provider';

    /**
     * orders.
     *
     * @var string
     */
    protected $orders;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->orders = Order::where('status', 'pending')->where('type', 'single')->where('created_at', '>', Carbon::now()->subMinutes(15)->toDateTimeString())->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $single = $this->option('single');
        if($single){
            $this->doAction();
            return;
        }
        $start = microtime(true);
        set_time_limit(60);
        for ($i = 0; $i < 59; ++$i) {
            if($i % 30 != 0){
                continue;
            }
            $this->doAction();

            //Sleep
            time_sleep_until($start + $i + 1);
        }


    }

    public function doAction()
    {
        $this->info(count($this->orders)." orders to process");
        foreach($this->orders as $order){


            $check = $order->checkTransaction();
            if(!$check){
                $this->info("Order ".$order->id.' has an error in checking');
            }
            $this->info("Processing order ".$order->id);
            $this->info("Order id ".$order->id." status is: ". $check['status']);
            if($check['status'] === '0'){
                $order->status = 'success';
                $order->save();

                $inputData = [
                    'donor_id' => $order->donor_id,
                    'amount' => $order->amount,
                    'order_id' => $order->id,
                    'payment_provider_data_id' => $check['payment_provider_data_id']
                ];

                $input = new MonetaryInput($inputData);
                if($input->save()){
                    $this->info("Payment entered into the system");
                }else{
                    $this->info("Payment CANNOT be entered into the system");
                }
                $this->info("\n --------------------------------------------------------- \n");

            }
        }
    }
}
