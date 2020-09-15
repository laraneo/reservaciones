<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingCancelled extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $refund_status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $refund_status)
    {
        $this->booking = $booking;
        $this->refund_status = $refund_status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(__('emails.booking_cancelled_subject', ['booking_id' => $this->booking->id]));
        return $this->view('vendor.emails.BookingCancelled');
    }
}
