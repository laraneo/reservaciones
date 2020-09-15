<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BookingReceived extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $user;

    public $extra_services;
    public $addons;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($booking, $user)
    {

        $this->addons = $booking->addons;

        if(count($this->addons))
        {
            foreach ($this->addons as $addon)
            {
                $this->extra_services .= $addon->title."<br>";
            }
        }

        $this->booking = $booking;
        $this->user = $user;

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->subject(__('emails.new_booking_title').' '.$this->booking->id);
        return $this->view('vendor.emails.bookingReceived')->with([
            'booking_id' => $this->booking->id,
            'business_name' => config('settings.business_name'),
            'category_photo' => $this->booking->package->category->photo->file,
            'primary_color' => config('settings.primary_color'),
            'secondary_color' => config('settings.secondary_color'),
            'customer_first_name' => $this->user->first_name,
            'customer_last_name' => $this->user->last_name,
            'booking_category' => $this->booking->package->category->title,
            'booking_package' => $this->booking->package->title,
            'booking_address' => $this->booking->booking_address,
            'booking_date' => $this->booking->booking_date,
            'booking_time' => $this->booking->booking_time,
            'extra_services' => $this->extra_services,
            'booking_invoice_amount' => $this->booking->invoice->amount." ".config('settings.default_currency'),
            'booking_invoice_payment_method' => $this->booking->invoice->payment_method,
            'is_paid' => $this->booking->invoice->is_paid,
            'facebook_link' => config('settings.facebook_link'),
            'twitter_link' => config('settings.twitter_link'),
            'google_plus_link' => config('settings.google_plus_link'),
            'instagram_link' => config('settings.instagram_link'),
            'pinterest_link' => config('settings.pinterest_link'),
			'locator' => $this->booking->locator
        ]);
    }
}
