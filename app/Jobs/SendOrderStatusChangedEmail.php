<?php

namespace App\Jobs;

use App\Mail\OrderStatusChanged;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendOrderStatusChangedEmail implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $status;

    /**
     * Create a new job instance.
     *
     * @param Order $order
     * @param string $status
     */
    public function __construct(Order $order, string $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Gửi email khi có thay đổi trạng thái đơn hàng
        Mail::to($this->order->user->email)
            ->send(new OrderStatusChanged($this->order, $this->status));
    }
}

