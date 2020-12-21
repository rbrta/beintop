<?php

namespace App\Jobs;

use App\ManagerOffer;
use App\Order;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessPayment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $order;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // renewal and calculation of expiration date only for reusable services
        if($this->order->service->periodindays) {
            $prevOrder = $this->order->getPrevious();

            // Account has previous active order
            if($prevOrder && $prevOrder->paid_status === Order::STATUS_ACTIVE) {
                $prevOrder->paid_status = Order::STATUS_TERMINATED;
                $prevOrder->save();

                // prolong by adding days to old date
                if($this->order->service_id === $prevOrder->service_id) {
                    $this->order->expiration_date = $prevOrder->is_expired
                        ? now()->addDays($prevOrder->service->periodindays)
                        : Carbon::parse($prevOrder->expiration_date)->addDays($prevOrder->service->periodindays);
                } else {
                    $this->order->expiration_date = now()->addDays($this->order->service->periodindays);
                }
            }
        }

        $this->order->paid_status = Order::STATUS_ACTIVE;
        $this->order->save();

        ManagerOffer::where([
            'user_id' => $this->order->user_id,
            'service_id' => $this->order->service_id,
            'price' => $this->order->total
        ])->delete();
    }
}
