<?php
 
namespace App\Http\Controllers;

use App\BookingPlayers;
use App\Addon;
use App\DrawAddon;
use App\SessionAddon;
use App\Booking;
use App\AddonBooking;
use App\DrawRequest;
use App\DrawPlayer;
use App\Invoice;
use App\SessionSlot;
use App\Settings;
use App\Mail\AdminBookingNotice;
use App\Mail\BookingInvoice;
use App\Mail\BookingReceived;
use App\Mail\BookingReceivedPlayer;
use App\Package;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Spatie\GoogleCalendar\Event;

	function getToken($length){
		 $token = "";
		 $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		 $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
		 $codeAlphabet.= "0123456789";
		 $max = strlen($codeAlphabet); // edited

		for ($i=0; $i < $length; $i++) {
			$token .= $codeAlphabet[random_int(0, $max-1)];
		}

		return $token;
	}	

	function getHtml($url, $post = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if(!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		} 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

class OfflinePaymentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Offline Payment Controller
    |--------------------------------------------------------------------------
    |
    | This controller accepts the form post of offline payment form
    | to make booking. It calculates
    | booking charges, save booking and send emails.
    |
    */

	public function getHtml($url, $post = null) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		if(!empty($post)) {
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		} 
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
	}

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.unpaid', compact('invoices'));
	}
	
	public function createPlayers($booking, $bookingType) {
				//attach all selected players to booking_players
				$package_id = Session::get('package_id');
				$sessionPlayers = DB::table('session_players')->where('session_email','=', Auth::user()->email)->get();
				foreach ($sessionPlayers as $value)  {		
					$token = md5($value->doc_id.$date.rand(microtime()));	
					$value->token = $token;
					
					if($bookingType == 1) {
						$bookingPlayer = BookingPlayers::create([
							'booking_id' => $booking,
							'doc_id' => $value->doc_id,
							'player_type' => $value->player_type,
							'confirmed' => 0,
							'token' => $token,
							'created_at' => time(),
							'updated_at' => time(),
						]);

						$sessionAddons = SessionAddon::where('doc_id', $value->doc_id)->where('package_id', $package_id)->get();
						if(count($sessionAddons)) {
							foreach ($sessionAddons as $key => $value) {
								AddonBooking::create([
									'booking_id' => $booking,
									'addon_id' => $value->addon_id,
									'booking_players_id' => $bookingPlayer->id,
									'cant' => $value->cant,
								]);
							}
						}						
					}
					
					if($bookingType == 2) {
						$drawPlayer = DrawPlayer::create([
							'draw_id' => Session::get('draw_id'),
							'draw_request_id' => $booking,
							'doc_id' => $session_player->doc_id,
							'player_type' => $session_player->player_type,
							'confirmed' => 0,
							'token' => $token,
							'created_at' => time(),
							'updated_at' => time(),
						]);
						$sessionAddons = SessionAddon::where('doc_id', $session_player->doc_id)->where('package_id', $package_id)->get();
						if(count($sessionAddons)) {
							foreach ($sessionAddons as $key => $value) {
								DrawAddon::create([
									'addon_id' => $value->addon_id,
									'draw_request_id' => $booking,
									'draw_players_id' => $drawPlayer->id,
									'cant' => $value->cant,
								]);
							}
						}
					}
				}
	}

    /**
     * Accept form post and process payment and booking
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
	 
 
    public function payOffline()
    {
        //validate module schedule

		date_default_timezone_set(env('LOCAL_TIMEZONE','America/Caracas'));
		//date_default_timezone_set('Asia/Kolkata');
		$setting = Settings::query()->first();
		$today = date("Y-m-d");
		$StartTime = $setting->bookingUser_startTime;
		$EndTime = $setting->bookingUser_endTime;
		$datetime1 = $today . ' ' . $StartTime;
		$datetime2 = $today . ' ' . $EndTime;

		$curDateTime = date("Y-m-d H:i");

		if (($curDateTime > $datetime1) && ($curDateTime < $datetime2)) {
				//echo "EN HORARIO";	
		}else
		{
			//echo $curDateTime . " - " . $datetime1 . " - " . $datetime2;
			//exit();
			$error_message_view_type = 1;
			
			Session::put('error_message_view_type', $error_message_view_type);
			return view('custom.restricted');
			//window.location.href = `custom/RestrictedUserBooking.php`;';
			//	echo '			window.location.href = `{{ url('login') }}`;';				
		}
		
		//check if there is another booking in same slot per category
		
		$package1 = Session::get('package_id');	
		$event_date1 = Session::get('event_date');
		$booking_slot1 =  Session::get('booking_slot');
		$bookingType =  Session::get('booking_type_id');

		$bookings_slot_count = count(DB::table('bookings')->where('booking_date','=', $event_date1)->where('booking_time','=', $booking_slot1)->where('status','<>', __('backend.cancelled'))->where('package_id','=', $package1)->get());

		echo $bookings_slot_count;
		//exit();

		if ($bookings_slot_count < 1){
			//OK
			//return view('custom.restricted');
		}else
		{
			$error_message_view_type = 2;
			
			Session::put('error_message_view_type', $error_message_view_type);
			return view('custom.restricted');
			//window.location.href = `custom/RestrictedUserBooking.php`;';
			//	echo '			window.location.href = `{{ url('login') }}`;';				
		}

		
		
		//check total bookings for current day already made
		$todayBookings = date("d-m-Y");
		
		$bookings_today = count(DB::table('bookings')->where('booking_date','=', $todayBookings)->where('status','<>', __('backend.cancelled'))->where('user_id','=', Auth::user()->id)->get());
		//$bookings_today = Auth::user()->bookings()->where('booking_date','=',($todayBookings));
		$bookings_perday =  config('settings.bookingUserPerDay');

		//echo $bookings_today . $bookings_perday . $todayBookings;
		
		if ($bookings_today <= $bookings_perday){
			//OK
			//return view('custom.restricted');
		}else
		{
			$error_message_view_type = 3;
			Session::put('error_message_view_type', $error_message_view_type);

			return view('custom.restricted');
			//window.location.href = `custom/RestrictedUserBooking.php`;';
			//	echo '			window.location.href = `{{ url('login') }}`;';				
		}
	
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

        if($setting->enable_gst)
        {
            $gst_amount = ( $setting->gst_percentage / 100 ) * $total;
            $gst_amount = round($gst_amount,2);
            $total_with_gst = $total + $gst_amount;
        }

        //decide if to charge with GST or without GST

        if($setting->enable_gst)
        {
            $amount_to_charge = $total_with_gst;
        }
        else
        {
            $amount_to_charge = $total;
        }

		//calculate locator number LA
		$date = date('Y-m-d H:i:s');
		$domain= config('settings.business_name', 'Bookify'); 

		//$locator = md5($domain.$date.rand(microtime()));	
		$locator = getToken(10);

		Session::put('locator', $locator );
		

        $package_id = Session::get('package_id');
		$package = Package::find($package_id);
		$sessionSlots = DB::table('session_slots')->where('session_email','=', Auth::user()->email)->where('booking_type','=', 2)->get();
		
		$session_players = DB::table('session_players')->where('session_email','=', Auth::user()->email)->get();
		
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
				if($bookingType == 1) {
					$booking = Booking::create([
						'user_id' => Auth::user()->id,
						'package_id' => $package_id,
						'booking_address' => Session::get('address'),
						'booking_instructions' => Session::get('instructions'),
						'booking_date' => Session::get('event_date'),
						'booking_time' => Session::get('booking_slot'),
						'google_calendar_event_id' => $calendarEvent->id,
						'status' => __('backend.processing'),
						'booking_time2' => Session::get('booking_time2'),
						'package_type_id' => Session::get('packageType')
					]);
					$this->createPlayers($booking->id, 1);
					DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
				}
				if($bookingType == 2) {
					if(count($sessionSlots)) {
						$countDraw = 0;
						foreach ($sessionSlots as $key => $value) {
							$countDraw = $countDraw + 1;
							$booking = DrawRequest::create([
								'draw_id' => Session::get('draw_id'),
								'user_id' => Auth::user()->id,
								'package_id' => $package_id,
								'draw_address' => Session::get('address'),
								'draw_instructions' => Session::get('instructions'),
								'draw_date' => $value->booking_date,
								'draw_time' => $value->booking_time,
								'google_calendar_event_id' => $calendarEvent->id,
								'status' => __('backend.processing'),
								'locator' => $locator,
								'priority' => $countDraw,
							]);
							$this->createPlayers($booking->id, 2);
						}
						DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
					}
					
				}
            } catch(\Exception $ex) {

                //save booking without calendar event id
                if($bookingType == 1) {
					$booking = Booking::create([
						'user_id' => Auth::user()->id,
						'package_id' => $package_id,
						'booking_address' => Session::get('address'),
						'booking_instructions' => Session::get('instructions'),
						'booking_date' => Session::get('event_date'),
						'booking_time' => Session::get('booking_slot'),
						'locator' => $locator,
						'status' => __('backend.processing'),
						'booking_time2' => Session::get('booking_time2'),
						'package_type_id' => Session::get('packageType')
					]);
					$this->createPlayers($booking->id, 1);
					DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
				}

				if($bookingType == 2) {
					if(count($sessionSlots)) {
						$countDraw = 0;
						foreach ($sessionSlots as $key => $value) {
							$countDraw = $countDraw + 1;
							$booking = DrawRequest::create([
								'draw_id' => Session::get('draw_id'),
								'user_id' => Auth::user()->id,
								'package_id' => $package_id,
								'draw_address' => Session::get('address'),
								'draw_instructions' => Session::get('instructions'),
								'draw_date' => $value->booking_date,
								'draw_time' => $value->booking_time,
								'locator' => $locator,
								'status' => __('backend.processing'),
								'priority' => $countDraw,
							]);
							$this->createPlayers($booking->id, 2);
						}
						DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
					}
				}
            }
        }

        else
        {
            //save booking without calendar event id
            if($bookingType == 1) {
				$booking = Booking::create([
					'user_id' => Auth::user()->id,
					'package_id' => $package_id,
					'booking_address' => Session::get('address'),
					'booking_instructions' => Session::get('instructions'),
					'booking_date' => Session::get('event_date'),
					'booking_time' => Session::get('booking_slot'),
					'locator' => $locator,
					'status' => __('backend.processing'),
					'booking_time2' => Session::get('booking_time2'),
					'package_type_id' => Session::get('packageType')
				]);
				$this->createPlayers($booking->id, 1);
				DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
			}
			
			if($bookingType == 2) {
				if(count($sessionSlots)) {
					$countDraw = 0;
					foreach ($sessionSlots as $key => $value) {
						$countDraw = $countDraw + 1;
						$booking = DrawRequest::create([
							'draw_id' => Session::get('draw_id'),
							'user_id' => Auth::user()->id,
							'package_id' => $package_id,
							'draw_address' => Session::get('address'),
							'draw_instructions' => Session::get('instructions'),
							'draw_date' => $value->booking_date,
							'draw_time' => $value->booking_time,
							'status' => __('backend.processing'),
							'locator' => $locator,
							'priority' => $countDraw,
						]);
						$this->createPlayers($booking->id, 2);
					}
					DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();
				}
			}
        }


        //attach all selected addons to addon_booking
        // $session_addons = DB::table('session_addons')->where('session_email','=', Auth::user()->email)->get();
        // foreach ($session_addons as $session_addon)
        // {
        //     Addon::find($session_addon->addon_id)->bookings()->attach($booking);
        // }

        //delete all session addons
        DB::table('session_addons')->where('session_email','=', Auth::user()->email)->delete();

        //send booking received email
        $user = User::find(Auth::user()->id);
        $admin = Role::where('name','Administrador')->with('users')->first();
        $admin = $admin->users()->get();
		
		
		//send email to other participants LA
		//$players = $booking->bookingplayers();

        try {

			if (config('settings.bookingEmailMainPlayer')==1)
			{
				Mail::to($user)->send(new BookingReceived($booking, $user));
				//echo "Correo jugador principal" . $user->email . "<br>";
			}

			//not to send invoice to user  LA
            //Mail::to($user)->send(new BookingInvoice($booking));

			if (config('settings.bookingEmailAdmins')==1)
			{
				echo "Admins" . "<br>" ;
				foreach($admin as $recipient)
				{
					Mail::to($recipient)->send(new AdminBookingNotice($booking, $recipient));
					//echo "Correo Admin" . $recipient . "<br>";
				}
			}
			
			//email to participants
			//$session_players = DB::table('session_players')->where('session_email','=', Auth::user()->email)->get();
			


			if (config('settings.bookingEmailPlayers')==1)
			{
				echo "Players" . "<br>" ;
				foreach ($session_players as $session_player)
				{
					//echo "player";
					$player_token=BookingPlayers::where('doc_id', $session_player->doc_id)->where('booking_id', $booking->id)->first()->token;
					//echo $player_token . "<br>";
					Mail::to($session_player)->send(new BookingReceivedPlayer($booking, $user, $session_player, $player_token));
					//echo "Correo Participante" . $session_player->email . "<br>";
				}			
			}
			//die();
			
			//SMS
			
			$urlBASE = $_ENV['APP_URL'];
			
			if ($urlBASE =='')
			{
				echo "DEFAULT value APP_URL";
				$urlBASE = "http://190.216.224.53:8084/";	
			}
			

			$sms_clientID =  config('settings.bookingSMS_clientid');
			//var_dump($sms_clientID);
			
			//echo config('settings.bookingSMSMainPlayer');
			
			if (config('settings.bookingSMSMainPlayer')==1)
			{
				//check if has phone number
				
				//echo "<br>SMS main player";
				
				$phone_number = $user->phone_number;
				//var_dump($phone_number);
				
				//$phone_number = "584122840974";

				if ($phone_number != '')
				{
					$message = "Reservacion " . config('settings.business_name') . " " . $booking->booking_date . " " . $booking->booking_time . " Localizador " .  $booking->locator;
					//Mail::to($user)->send(new BookingReceived($booking, $user));
					$url =	$urlBASE . "wsSMSGateway.php?clientid=" .  $sms_clientID .  "&number=" . $phone_number . "&message=" . rawurlencode($message);	
					
					
					//$url = rawurlencode($url);
					//echo $url;
					
					$resultSMS = getHtml($url);
					
					//var_dump($resultSMS);
					//$resultSMS = file_get_contents($url); 
					//$booking->booking_date
					//$booking->booking_time
				}
			}
			//echo config('settings.bookingSMSPlayers');
			if (config('settings.bookingSMSPlayers')==1)
			{
				foreach ($session_players as $session_player)
				{
					//echo "<br>SMS player";				
					//check if has phone number
					$phone_number = $session_player->phone_number;	
					
					//var_dump($phone_number);
					
					//$phone_number = "584122840974";
					if ($phone_number != '')
					{
						$message = "Incluido en Reservacion " . config('settings.business_name') . " " . $booking->booking_date . " " . $booking->booking_time . " de " .  Auth::user()->first_name . " " . Auth::user()->last_name . " confirmar por email su asistencia";				
					
						$url =	$urlBASE . "wsSMSGateway.php?clientid=" .  $sms_clientID .  "&number=" . $phone_number . "&message=" . rawurlencode($message);	
						
						//$url = rawurlencode($url);
						//echo $url;
						
						$resultSMS = getHtml($url);
						
						//var_dump($resultSMS);
						//$resultSMS = file_get_contents($url); 

						//Mail::to($session_player)->send(new BookingReceivedPlayer($booking, $user, $session_player));
					}
				}			
			}			


			//delete all session players
			DB::table('session_players')->where('session_email','=', Auth::user()->email)->delete();

			//delete all session slots
			DB::table('session_slots')->where('session_email','=', Auth::user()->email)->delete();
			
			//exit();

            return redirect()->route('thankYou');

        } catch(\Exception $ex) {

            return redirect()->route('thankYou');

        }

    }
}
