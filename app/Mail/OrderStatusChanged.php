<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Order;

class OrderStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $newStatus;

    /**
     * Create a new message instance.
     *
     * @param Order $order
     * @param string $newStatus
     */
    public function __construct(Order $order, string $newStatus)
    {
        $this->order = $order;
        $this->newStatus = $newStatus;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Thông báo: Trạng thái đơn hàng đã thay đổi')
                    ->view('emails.order_status_changed')
                    ->with([
                        'order' => $this->order,
                        'newStatus' => $this->newStatus,
                    ]);
    }
}
