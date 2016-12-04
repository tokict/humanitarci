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
    protected $signature = 'CheckPayments';

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

        $this->orders = Order::where('status', 'pending')->where('type', 'single')->where('created_at', '>', Carbon::now()->subWeek())->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   $this->info(count($this->orders)." orders to process");
        foreach($this->orders as $order){
            $check = $order->checkTransaction();
            $this->info("Processing order ".$order->id);
            $this->info("Order id ".$order->id." status is: ". $check['status']);
            if($check['status'] == 'done'){
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
                $this->info("");

            }
        }
    }
}
