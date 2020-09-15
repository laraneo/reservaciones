<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Booking;
use App\Invoice;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Package;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use PayPal\Api\PaymentExecution;
use Spatie\GoogleCalendar\Event;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;


class PaypalController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Paypal Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for calculating booking charges,
    | taking user to paypal, get cURL response from paypal. In case of
    | payment success, this controller will create a booking with all
    | details. In case of payment failure it will show a payment failed page.
    |
    */


    private $_api_context;


    public function __construct()
    {

        $settings = array(

            'mode' => config('settings.paypal_sandbox_enabled') ? 'sandbox' : 'live',
            'http.ConnectionTimeOut' => 1000,
            'log.LogEnabled' => true,
            'log.FileName' => storage_path() . '/logs/paypal.log',
            'log.LogLevel' => 'FINE'

        );

        $this->_api_context = new ApiContext(new OAuthTokenCredential(config('settings.paypal_client_id'),
            config('settings.paypal_client_secret')));

        $this->_api_context->setConfig($settings);
    }


    /**
     * Calculate charges and initiate payment
     * @return mixed
     */

    public function payWithPaypal()
    {

        //calculate total amount to be charged

        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email','=', Auth::user()->email)->get();

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


        //create Payer

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');


        //create billable items

        $item = new Item();
        $item->setName(config('settings.business_name')." Booking")
        ->setCurrency(config('settings.default_currency'))
            ->setQuantity(1)
            ->setPrice($amount_to_charge);

        $item_list = new ItemList();
        $item_list->setItems(array($item));


        //set amount to be charged

        $amount = new Amount();
        $amount->setCurrency(config('settings.default_currency'))
            ->setTotal($amount_to_charge);


        //create transaction

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list);

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('paymentSuccessful'))
        ->setCancelUrl(route('paymentFailed'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));


        $payment->create($this->_api_context);

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }


        //save payment ID and redirect to paypal for payment
        Session::put('paypal_payment_id', $payment->getId());
        if(isset($redirect_url)) {
            return Redirect::away($redirect_url);
        }


        //set error and redirect to finalize booking
        Session::flash('paypal_error', __('backend.paypal_error'));
        return redirect()->route('loadFinalStep');

    }

    /**
     * If payment is successful, save booking, send emails and show success.
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    public function paymentSuccessful(Request $request)
    {
        //calculate total amount to be charged

        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email','=', Auth::user()->email)->get();

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


        //get payment ID saved already

        $payment_id = Session::get('paypal_payment_id');
        Session::forget('paypal_payment_id');

        //check if customer completed payment

        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {

            //payment not completed, redirect to payment failed

            return redirect()->route('paymentFailed');

        }

        //payment is successful, lets get payment data

        $payment = Payment::get($payment_id, $this->_api_context);
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));

        //Execute the payment

        $result = $payment->execute($execution, $this->_api_context);


        if($result->getState() == 'approved') {

            //success, proceed to save booking

            $package_id = Session::get('package_id');
            $package = Package::find($package_id);

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

                    //save booking with calendar event id
                    $booking = Booking::create([
                        'user_id' => Auth::user()->id,
                        'package_id' => $package_id,
                        'booking_address' => Session::get('address'),
                        'booking_instructions' => Session::get('instructions'),
                        'booking_date' => Session::get('event_date'),
                        'booking_time' => Session::get('booking_slot'),
                        'google_calendar_event_id' => $calendarEvent->id,
                        'status' => __('backend.processing'),
                    ]);

                } catch(\Exception $ex) {

                    //save booking without calendar event id
                    $booking = Booking::create([
                        'user_id' => Auth::user()->id,
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
                //save booking without calendar event id
                $booking = Booking::create([
                    'user_id' => Auth::user()->id,
                    'package_id' => $package_id,
                    'booking_address' => Session::get('address'),
                    'booking_instructions' => Session::get('instructions'),
                    'booking_date' => Session::get('event_date'),
                    'booking_time' => Session::get('booking_slot'),
                    'status' => __('backend.processing'),
                ]);
            }


            //save invoice
            Invoice::create([
                'booking_id' => $booking->id,
                'user_id' => Auth::user()->id,
                'transaction_id' => $payment_id,
                'amount' => $amount_to_charge,
                'payment_method' => __('app.paypal'),
                'is_paid' => 1,
            ]);

            //attach all selected addons to addon_booking
            $session_addons = DB::table('session_addons')->where('session_email','=', Auth::user()->email)->get();
            foreach ($session_addons as $session_addon)
            {
                Addon::find($session_addon->addon_id)->bookings()->attach($booking);
            }

            //delete all session addons
            DB::table('session_addons')->where('session_email','=', Auth::user()->email)->delete();

            //send booking received email
            $user = User::find(Auth::user()->id);
            $admin = Role::where('name','Administrador')->with('users')->first();
            $admin = $admin->users()->get();

            try {

                Mail::to($user)->send(new BookingReceived($booking, $user));
                Mail::to($user)->send(new BookingInvoice($booking));

                foreach($admin as $recipient)
                {
                    Mail::to($recipient)->send(new AdminBookingNotice($booking, $recipient));
                }

                return redirect()->route('thankYou');

            } catch(\Exception $ex) {

                return redirect()->route('thankYou');

            }

        }

        //error, just redirect

        return redirect()->route('paymentFailed');


    }

    /**
     * Payment failed
     * @return \Illuminate\Http\RedirectResponse
     */
    public function paymentFailed()
    {
        return redirect()->route('paymentFailed');
    }
}
