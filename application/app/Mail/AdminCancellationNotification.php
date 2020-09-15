<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AdminCancellationNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $admin)
    {
        $this->booking = $booking;
        $this->user = $admin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(__('emails.admin_cancel_subject'));
        return $this->view('vendor.emails.AdminCancelNotification');
    }
}
