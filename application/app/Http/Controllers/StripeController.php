<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Invoice;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Package;
use App\Role;
use App\Booking;
use App\User;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

class StripeController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Stripe Controller
    |--------------------------------------------------------------------------
    |
    | This controller accepts the form post of credit card payment form
    | containing $request[stripe-token] to capture payment. It calculates
    | booking charges, capture payment, save booking and send emails.
    |
    */


    /**
     * Accept form post and process payment and booking
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payWithStripe(Request $request)
    {

        //calculate total amount to be charged
        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email','=', $request['email'])->get();

        //calculate total
        $total = $package->price;

        //add addons price if any
        foreach($session_addons as $session_addon)
        {
            $total = $total + Addon::find($session_addon->addon_id)->price;
        }

        //check if GST is enabled and add it to total invoice
        if(config('settings.enable_gst'))
        {
            $gst_amount = ( config('settings.gst_percentage') / 100 ) * $total;
            $gst_amount = round($gst_amount,2);
            $total_with_gst = $total + $gst_amount;
        }

        //decide if to charge with GST or without GST
        if(config('settings.enable_gst'))
        {
            $amount_to_charge = $total_with_gst;
        }
        else
        {
            $amount_to_charge = $total;
        }

        //create stripe charge and capture immediately
        $charge = Stripe::charges()->create([
            'currency' => config('settings.default_currency'),
            'amount'   => $amount_to_charge,
            'source'   => $request['stripe-token'],
            'description' => config('settings.business_name')." Booking",
            'statement_descriptor' => config('settings.business_name')." Booking",
            'capture' => true,
        ]);

        //charge captured, check charge status and save booking + invoice with $charge['id']
        if($charge['status']=="succeeded")
        {

            $package_id = Session::get('package_id');
            $package = Package::find($package_id);

            //if sync is enabled
            if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id'))
            {
                //create timestamp
                $time_string = Session::get('event_date')." ".Session::get('booking_slot');
                $start_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'));
                $end_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'))->addMinutes($package->duration);

                try {

                    //create google calendar event
                    $event = new Event;
                    $event->name = $package->category->title." - ".$package->title." ".__('app.booking')." - ".__('backend.processing');
                    $event->startDateTime = $start_instance;
                    $event->endDateTime = $end_instance;
                    $calendarEvent = $event->save();

                    //create booking with calender event id
                    $booking = Booking::create([
                        'user_id' => $request['user_id'],
                        'package_id' => $package_id,
                        'booking_address' => Session::get('address'),
                        'booking_instructions' => Session::get('instructions'),
                        'booking_date' => Session::get('event_date'),
                        'booking_time' => Session::get('booking_slot'),
                        'google_calendar_event_id' => $calendarEvent->id,
                        'status' => __('backend.processing'),
                    ]);

                } catch(\Exception $ex) {

                    //create booking without calendar event id
                    $booking = Booking::create([
                        'user_id' => $request['user_id'],
                        'package_id' => $package_id,
                        'booking_address' => Session::get('address'),
                        'booking_instructions' => Session::get('instructions'),
                        'booking_date' => Session::get('event_date'),
                        'booking_time' => Session::get('booking_slot'),
                        'status' => __('backend.processing'),
                    ]);

                }

            }

            else
            {
                //create booking without calendar event id
                $booking = Booking::create([
                    'user_id' => $request['user_id'],
                    'package_id' => $package_id,
                    'booking_address' => Session::get('address'),
                    'booking_instructions' => Session::get('instructions'),
                    'booking_date' => Session::get('event_date'),
                    'booking_time' => Session::get('booking_slot'),
                    'status' => __('backend.processing'),
                ]);
            }



            Invoice::create([
                'booking_id' => $booking->id,
                'user_id' => $request['user_id'],
                'transaction_id' => $charge['id'],
                'amount' => $amount_to_charge,
                'payment_method' => __('app.credit_card'),
                'is_paid' => 1,
            ]);

            //attach all selected addons to addon_booking
            foreach ($session_addons as $session_addon)
            {
                $addon = Addon::find($session_addon->addon_id);
                $addon->bookings()->attach($booking);
            }

            //delete all session addons
            DB::table('session_addons')->where('session_email','=',$request['email'])->delete();

            //send booking received email
            $user = User::find($request['user_id']);
            $admin = Role::where('name','Administrador')->with('users')->first();
            $admin = $admin->users()->get();;

            try {

                Mail::to($request->user())->send(new BookingReceived($booking , $user));
                Mail::to($request->user())->send(new BookingInvoice($booking));

                foreach($admin as $recipient)
                {
                    Mail::to($recipient)->send(new AdminBookingNotice($booking , $recipient));
                }

                return redirect()->route('thankYou');

            } catch(\Exception $ex) {

                return redirect()->route('thankYou');

            }
        }

        return redirect()->route('paymentFailed');

    }
}
