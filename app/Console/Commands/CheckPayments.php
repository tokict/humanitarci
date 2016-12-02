<?php

namespace App\Console\Commands;

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

        $this->orders = Order::where('status', 'pending')->where('created_at', '>', Carbon::now()->subWeek())->get();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {   $this->info(count($this->orders)." orders to process");
        foreach($this->orders as $order){
            $this->info("Processing order ".$order->order_number);
            $this->info($order->checkTransaction());
        }
    }
}
