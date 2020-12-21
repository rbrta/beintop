<?php

namespace App\Console\Commands;

use App\Account;
use App\Jobs\ProcessPayment;
use App\Order;
use Illuminate\Console\Command;

class MakeOrderActive extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'order:make-active';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        $orders = Order::with('account', 'service')->where('paid_status', '!=', Order::STATUS_ACTIVE)->get();
        $selectOrder = [];

        foreach ($orders as $order) {
            $selectOrder[] = "ID: {$order->id} | Status: {$order->paid_status} | Total: {$order->total} | Account: {$order->account->account_name} | Service: " . ($order->service ? $order->service->name : 'none');
        }

        $selectedOrder = $this->choice(
            'Select account',
            $selectOrder
        );

        $selectedOrderIndex = array_search($selectedOrder, $selectOrder);
        $selectedOrder = $orders[$selectedOrderIndex];

        ProcessPayment::dispatch($selectedOrder);

        $this->info('The order has been successfully activated.');
    }
}
