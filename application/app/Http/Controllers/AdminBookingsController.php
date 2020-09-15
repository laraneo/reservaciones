<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Mail\BookingCancelled;
use Carbon\Carbon;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Payment;
use PayPal\Api\RefundRequest;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Spatie\GoogleCalendar\Event;
use PayPal\Api\Amount;
use PayPal\Api\Sale;

class AdminBookingsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Bookings Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing bookings views to admin, to
    | show all bookings, provide ability to edit and delete specific booking
    | and to cancel booking.
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bookings = Booking::all();
        return view('bookings.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = Booking::find($id);
        $addons = $booking->addons->all();
        return view('bookings.view', compact('booking', 'addons'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //generating a string for off days

        $off_days = DB::table('booking_times')
            ->where('is_off_day', '=', '1')
            ->get();



        $daynum = array();

        foreach ($off_days as $off_day)
        {
            if($off_day->id != 7)
            {
                $daynum[] = $off_day->id;
            }
            else
            {
                $daynum[] = $off_day->id - 7;
            }
        }

        $disable_days_string = implode(",", $daynum);

        $booking = Booking::find($id);
        return view('bookings.edit', compact('booking', 'disable_days_string'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $booking = Booking::find($id);
        $booking->update($input);

        if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != NULL)
        {
            if($input['status']==__('backend.processing'))
            {
                $new_status = __('backend.processing');
            }
            else if($input['status']==__('backend.in_progress'))
            {
                $new_status = __('backend.in_progress');
            }
            else if($input['status']==__('backend.completed'))
            {
                $new_status = __('backend.completed');
            }
            else if($input['status']==__('backend.cancelled'))
            {
                $new_status = __('backend.cancelled');
            }

            try {
                //update google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->name = $booking->package->category->title." - ".$booking->package->title." ".__('app.booking')." - ".$new_status;
                $event->save();
            } catch(\Exception $ex) {
                //do nothing
            }
        }

        //set session message and redirect back to bookings.show
        Session::flash('booking_updated', __('backend.booking_updated'));
        return redirect()->route('bookings.show',$id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $booking = Booking::findorFail($id);
        $booking->addons()->detach();
        Booking::destroy($booking->id);

        if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != NULL)
        {
            try {
                //remove google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->delete();
            } catch(\Exception $ex) {
                //do nothing
            }
        }

        //set session message and redirect back to bookings.index
        Session::flash('booking_deleted', __('backend.booking_deleted'));
        return redirect('/bookings');
    }

    /**
     *
     * Cancel a booking
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */

    public function cancel(Request $request, $id)
    {
        //get input

        $input = $request->all();

        //set booking status to cancelled

        $booking = Booking::find($id);
        $input_booking['status'] = __('backend.cancelled');
        $booking->update($input_booking);

        //If have cancel request, set to Completed

        $input_cancel_request['status'] = __('backend.completed');
        $cancel_request = $booking->cancel_request()->first();
        if(count($cancel_request))
        {
            $cancel_request->update($input_cancel_request);
        }

        //refund if selected

        if($input['refund_selection'] == 1)
        {

            //issue refund

            $invoice = $booking->invoice()->first();

            if($invoice['payment_method'] == __('app.credit_card'))
            {
                //refund via stripe

                Stripe::refunds()->create($booking->invoice->transaction_id, $booking->invoice->amount , [
                    'reason' => 'requested_by_customer'
                ]);

                //update invoice to refunded

                $input_invoice['is_refunded'] = 1;
                $booking->invoice()->update($input_invoice);

            }
            else if($invoice['payment_method'] == __('app.paypal'))
            {


                //refund via paypal - get relative paypal transaction

                $payment = Payment::get($booking->invoice->transaction_id, $this->_api_context);
                $transactions = $payment->getTransactions();
                $resources = $transactions[0]->getRelatedResources();

                //get saleID from transaction

                $sale = $resources[0]->getSale();
                $saleID = $sale->getId();

                //set amount and currency

                $amt = new Amount();
                $amt->setTotal($booking->invoice->amount)
                    ->setCurrency(config('settings.default_currency'));

                //create refund request

                $refund = new RefundRequest();
                $refund->setAmount($amt);


                //set saleID for refund

                $sale = new Sale();
                $sale->setId($saleID);


                //execute refund

                $sale->refundSale($refund, $this->_api_context);

                //update invoice to refunded

                $input_invoice['is_refunded'] = 1;
                $booking->invoice()->update($input_invoice);

            }

            else if($invoice['payment_method']== __('app.offline_payment'))
            {
                //update invoice to refunded

                $input_invoice['is_refunded'] = 1;
                $booking->invoice()->update($input_invoice);
            }

            //send email to customer - refund true

            try {
                Mail::to($booking->user)->send(new BookingCancelled($booking , "1"));
            } catch(\Exception $ex) {
                //do nothing
            }

        }

        else
        {
            //send email to customer - refund false
            try {
                Mail::to($booking->user)->send(new BookingCancelled($booking, "0"));
            } catch (\Exception $ex) {
                //do nothing
            }
        }

        //update google calendar event if set

        if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != NULL)
        {

            $new_status = __('backend.cancelled');

            try {
                //update google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->name = $booking->package->category->title." - ".$booking->package->title." ".__('app.booking')." - ".$new_status;
                $event->save();
            } catch(\Exception $ex) {
                //do nothing
            }
        }


        //set success message and redirect to booking page

        Session::flash('booking_cancelled', __('backend.booking_cancelled_message'));

        return redirect()->route('bookings.show',$id);
    }

    public function update_booking_time(Request $request, $id)
    {
        $booking = Booking::find($id);

        $input = $request->all();

        //update booking

        $booking->update([
            'booking_date' => $input['event_date_bk'],
            'booking_time' => $input['booking_slot']
        ]);


        //if sync is enabled and booking have calender event_id

        if(config('settings.sync_events_to_calendar') && config('settings.google_calendar_id') && $booking->google_calendar_event_id != NULL) {

            //create new timestamp
            $time_string = $input['event_date_bk'] . " " . $input['booking_slot'];
            $start_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'));
            $end_instance = Carbon::createFromTimestamp(strtotime($time_string), env('LOCAL_TIMEZONE'))->addMinutes($booking->package->duration);

            try{
                //update google calendar event
                $event = Event::find($booking->google_calendar_event_id);
                $event->startDateTime = $start_instance;
                $event->endDateTime = $end_instance;
                $event->save();
            } catch(\Exception $ex) {
                //do nothing
            }

        }

        return redirect()->route('bookings.index');
    }
}
