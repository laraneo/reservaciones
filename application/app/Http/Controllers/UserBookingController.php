<?php

namespace App\Http\Controllers;

use App\Addon;
use App\SessionAddon;
use App\SessionPlayer;
use App\Draw;
use App\BookingTime;
use App\Settings;
use App\DrawRequest;
use App\Booking;
use App\Event;
use App\Category;
use App\Package;
use Carbon\Carbon;
use App\SessionSlot;
use App\PackagesType;
use App\AddonsParameter;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
//use Spatie\GoogleCalendar\Event;

use DateTime;
use DateInterval;
use DatePeriod;

class UserBookingController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | User Booking Controller
    |--------------------------------------------------------------------------
    |
    | This controller loads all frontend booking views and process
    | all requests. Also loads specific user's bookings to view.
    |
    */


    /**
     * get user bookings and load user bookings view
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $bookings = Auth::user()->bookings()->orderBy('created_at', 'ASC')->get();
        return view('customer.bookings.index', compact('bookings'));
    }

    /**
     * Initialize a booking
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadBooking()
    {
        $settings = Settings::first();
        $reglamento_link = $settings->REGLAMENTO_LINK;
        $reglamento_label = $settings->REGLAMENTO_LABEL;
        $random_pass_string = str_random(10);
        $categories = Category::where('is_active', 1)->get();
        return view('welcome', compact('random_pass_string', 'categories','reglamento_link', 'reglamento_label'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackages()
    {

        $settings = Settings::query()->first();;
        $player = auth()->user();
        $category_id = \request('parent');  
        $categoryType = Category::find($category_id);
        $categoryType = $categoryType->category_type;

        $fecha = Carbon::now()->format('d-m-Y');
        $params = array( $categoryType, 1, $player->doc_id, $fecha);
        $query = 'exec CalcularParticipacionesPorFecha ?,?,?,?';
        $data = \DB::select($query,$params);
        $errMessage = '';
        $unidadmedida = '';
        if($categoryType == 0) $unidadmedida= 'partidas';
		if($categoryType == 1) $unidadmedida= 'minutos';
        $messagePerDayWeekMonth = "No puede exceder el numero de ".$unidadmedida."";

        $conditionPerDay = $categoryType == 0 ? $settings->bookingUserPlayPerDay : $settings->bookingUser_maxTimePerDay;
		$conditionPerWeek = $categoryType == 0 ? $settings->bookingUserPlayPerWeek : $settings->bookingUser_maxTimePerWeek;
		$conditionPerMonth = $categoryType == 0 ? $settings->bookingUserPlayPerMonth : $settings->bookingUser_maxTimePerMonth;
        
        if($data) {
            $calculoDia = (int)$data[0]->dia ? (int)$data[0]->dia: 0;
			$calculoSemana = (int)$data[0]->semana ? (int)$data[0]->semana : 0;
            $calculoMes = (int)$data[0]->mes ? (int)$data[0]->mes : 0;
            if ($calculoDia >= $conditionPerDay) {
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por día. <br>";
            }
    
            if ($calculoSemana >= $conditionPerWeek) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Semana. <br>";
            }
    
            if ($calculoMes >= $conditionPerMonth) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Mes.";
            }
            $sDebugSP  = $query . "--> Dia=%s, Semana=%s, Mes=%s";
            $sDebugSP = str_replace("?","%s", $sDebugSP );
            $sDebugSP = sprintf($sDebugSP,$categoryType, 1, $player->doc_id, $fecha, $calculoDia, $calculoSemana, $calculoMes);
            Log::info($sDebugSP);
        }
        if($errMessage !== '') {
            return response()->json([ 
                'success' => $errMessage !== '' ? true : false,
                'message' => $errMessage,
            ]);
        } 
         
        $packages = Package::where('category_id', $category_id)->where('is_active', 1)->get();
        return view('blocks.packages', compact('packages'));
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackagesByCategory(Request $request)
    {
        $category = Session::get('customCategory');
        $packages = Package::where('category_id', $category)->where('is_active', 1)->get();
        return response()->json([ 'success' => true, 'data' => $packages ]);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getPackagesByType(Request $request)
    {

        $settings = Settings::query()->first();;
        $player = auth()->user();
        $categoryType = Category::find($request['id']);
        $categoryType = $categoryType->category_type;

        $fecha = Carbon::now()->format('d-m-Y');
        $params = array( $categoryType, 1, $player->doc_id, $fecha);
            
        $query = 'exec CalcularParticipacionesPorFecha ?,?,?,?';
        $data = \DB::select($query,$params);
        $errMessage = '';
        $unidadmedida = '';
        if($categoryType == 0) $unidadmedida= 'partidas';
		if($categoryType == 1) $unidadmedida= 'minutos';
        $messagePerDayWeekMonth = "No puede exceder el numero de ".$unidadmedida."";

        $conditionPerDay = $categoryType == 0 ? $settings->bookingUserPlayPerDay : $settings->bookingUser_maxTimePerDay;
		$conditionPerWeek = $categoryType == 0 ? $settings->bookingUserPlayPerWeek : $settings->bookingUser_maxTimePerWeek;
		$conditionPerMonth = $categoryType == 0 ? $settings->bookingUserPlayPerMonth : $settings->bookingUser_maxTimePerMonth;

        if($data) {
            $calculoDia = (int)$data[0]->dia ? (int)$data[0]->dia: 0;
			$calculoSemana = (int)$data[0]->semana ? (int)$data[0]->semana : 0;
            $calculoMes = (int)$data[0]->mes ? (int)$data[0]->mes: 0;
            if ($calculoDia >= $conditionPerDay) {
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por día. <br>";
            }
    
            if ($calculoSemana >= $conditionPerWeek) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Semana. <br>";
            }
    
            if ($calculoMes >= $conditionPerMonth) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Mes.";
            }
            $sDebugSP  = $query . "--> Dia=%s, Semana=%s, Mes=%s";
            $sDebugSP = str_replace("?","%s", $sDebugSP );
            $sDebugSP = sprintf($sDebugSP,$categoryType, 1, $player->doc_id, $fecha, $calculoDia, $calculoSemana, $calculoMes);
            Log::info($sDebugSP);
        }
        if($errMessage !== '') {
            return response()->json([ 
                'success' => false,
                'message' => $errMessage,
            ]);
        } 

        $dates = array(); 
        $maxDays = $settings->bookingUser_maxDays + 1;
        for ($i=0; $i < $maxDays ; $i++) {
            if($i == 0) {
                array_push($dates, [ 'date' => Carbon::now() ]);
            } else {
                array_push($dates, [ 'date' => Carbon::now()->addDay($i) ]);
            }      
        }

        $category = Category::where('id', $request['id'])->whereHas('packages', function($q) {
            $q->where('is_active', 1);
        })->get();
        return response()->json([ 'success' => true, 'data' => $category, 'dates' => $dates ]);
    }

    public function buildSelectedHours($hour, $cant, $interval) {
        $array = array();
        if($cant == 0) {
            $time = strtoupper(Carbon::parse($hour)->format('g:i A'));
            array_push($array, $time);
        } else {
            $time = strtoupper(Carbon::parse($hour)->format('g:i A'));
            array_push($array, $time);
            for ($i=0; $i < $cant ; $i++) { 
               $position = $i + 1;
               $newInterval = $position * $interval;
               $time = strtoupper(Carbon::parse($hour)->addMinutes($newInterval)->format('g:i A'));
               array_push($array, $time);
            }
        }
        return $array;
    }

    public function getSlotsPerTime($date ,$packageTypeId, $hour, $slotHour) {
 
        $parseHour = DateTime::createFromFormat('h:ia', $hour);
        $parseHour = $parseHour->format('H:i:s');
        $currentDate = $date.' '.$parseHour;
        $startHour = Carbon::parse($currentDate);

        
       
        $packageType = PackagesType::find($packageTypeId);
        $package = Package::find($packageType->package_id);
        $tennisCondition = (int)$packageType->length / (int)$package->duration;
        $tennisCondition = $tennisCondition == 1 ? 0 : $tennisCondition -1;
        $arrayHours = $this->buildSelectedHours($hour, $tennisCondition, $package->duration);
        $exist = false;

        foreach ($arrayHours as $key => $value) {
            if($value == strtoupper(Carbon::parse($slotHour)->format('g:i A'))) {
                $exist = true;
            }
        }

        return $exist;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTimingSlots()
    {
			echo "Leyenda";
       
            echo '<div class="row">';
	   
            if(Session::get('booking_type_id') == 2) {
                echo '<div class="col-md-2">';
                echo '<a class="btn btn-outline-yellow btn-lg btn-block btn-slot disabled"> DISPONIBLE</a>';
                echo '</div>';
                
                echo '<div class="col-md-2">';
                echo '<a class="btn   btn-lg btn-block  btn-slot btn-warning disabled">SELECCION</a>';
                echo '</div>';
            } else {
                echo '<div class="col-md-2">';
                echo '<a class="btn btn-outline-dark btn-lg btn-block btn-slot disabled"> DISPONIBLE</a>';
                echo '</div>';
                
                echo '<div class="col-md-2">';
                echo '<a class="btn   btn-lg btn-block  btn-slot btn-warning disabled">EVENTO</a>';
                echo '</div>';
                
                echo '<div class="col-md-2">';
                echo '<a class="btn   btn-lg btn-block  btn-slot btn-secondary disabled"><font color="FFFFFF"> EXPIRADO</font></a>';
                echo '</div>';
                
                echo '<div class="col-md-2">';
                echo '<a class="btn   btn-lg btn-block  btn-slot btn-success disabled"><font color="FFFFFF"> RESERVADO</font></a>';
                echo '</div>';

                
                echo '<div class="col-md-2">';
                echo '<a class="btn   btn-lg btn-block  btn-slot btn-danger disabled"><font color="FFFFFF"> EN PROCESO </font></a>';
                echo '</div>';
            }

			echo '</div>';
	
		date_default_timezone_set(env('LOCAL_TIMEZONE','America/Caracas'));
				
		//$now = date('m/d/Y h:i:s a', time());
		//DB::table('session_slots')->where('expiration_date','<', time())->delete();
		//DB::table('session_slots')->where('expiration_date','<', GETDATE())->delete();
       
		
        $categoryType = Session::get('categoryType');
			//delete all session slots expired
            require 'config.inc';
       
            $connectionInfo = array( 
                "Database"=> $database,
                "UID"=> $username, 
                "PWD"=> $password
                );

            $connection = sqlsrv_connect($servername, $connectionInfo);
            
			$queryExpiredSlots = "DELETE FROM session_slots WHERE expiration_date<GETDATE()";

			// Check connection 
			if (!$connection) 
			{ 
				$has_errors = 1;	
				echo $err_message =  $err_message . "<br>Database connection failed"; 
				exit(); //die();
			}
			$resultqueryBookingPlayerCount = sqlsrv_query($connection, $queryExpiredSlots); 
		
        $bookingType =  Session::get('booking_type_id');
		
        //get selected event date
        $event_date = \request('event_date');
        $requestPackageId = \request('package');

        //get selected package_id
        $selected_package_id = Session::get('package_id');

        if($requestPackageId !== null) {
            Session::put('package_id',$requestPackageId);
            $selected_package_id = $requestPackageId;
        }

        $drawId = Session::get('draw_id');
		
        echo Package::find($selected_package_id)->title; 
        
        //get selected category_id
        $selected_category_id = Package::find($selected_package_id)->category->id;

        //get day name to select slot timings
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);
        $settings = Settings::query()->first();	
               
		//use booking schedule per package or global
		if($settings->bookingTime_perpackage)
		//if (1==1)	
		{
			
			//require 'config.inc';
			
			 $servername = $_ENV['DB_HOST'];
			 $port = $_ENV['DB_PORT'];
			 $username=  $_ENV['DB_USERNAME'];
			 $password = $_ENV['DB_PASSWORD'];
             $database = $_ENV['DB_DATABASE'];
             
             $connectionInfo = array( 
                "Database"=> $database,
                "UID"=> $username, 
                "PWD"=> $password
                );
              
			$conn = sqlsrv_connect("".$servername.",".$port."", $connectionInfo);
			// Check connection
			if (!$conn) {
				die("Connection failed: " . sqlsrv_errors());
			}
			
			
            //validar horario para confirmacion con horario de uso de app
            $timePackage = $bookingType == 1 ? 'booking' : 'draw';

			$sql = "select opening_time, closing_time from ".$timePackage."_times_packages WHERE package_id=" . $selected_package_id . " AND  number=" . $today_number ;
            
            if($bookingType == 2) {
                $sql = "SELECT e.time1 as opening_time, e.time2 as closing_time  from events e , draws d where e.id=d.event_id and d.id = ".$drawId."";
            }

            //echo $sql;
			
			$result1 = sqlsrv_query($conn, $sql);
			if( $result1 === false) {
				die( print_r( sqlsrv_errors(), true) );
			}

			while( $row = sqlsrv_fetch_array( $result1, SQLSRV_FETCH_ASSOC) ) {

				if($bookingType == 2) {

					  $hour_start = date_format($row["opening_time"], 'h:i A');
					  $hour_end = date_format($row["closing_time"], 'h:i A');
				}
				else
				{
					  $hour_start = $row["opening_time"];					
					  $hour_end = $row["closing_time"];				
				}
			}

			sqlsrv_free_stmt( $result1);
			sqlsrv_close($conn);		
		}
		else
		{
			$booking_time = BookingTime::findOrFail($today_number);
			//decide starting and ending hours for selected date
			$hour_start = $booking_time->opening_time;
			$hour_end = $booking_time->closing_time;
			
		}
		/*
		$hour_start ='06:00 AM';
		$hour_end='08:00 PM';
		*/
		echo " @ ".$event_date.", ".  $hour_start . " - " . 	$hour_end . "<br>";
		
        //decide what will be the duration of each slot
        if($settings->slots_with_package_duration)
        {
            //use package duration as slot duration
            $package = Package::find($selected_package_id);
            $slot_duration = $package->duration * 60;
        }
        else
        {
            //use regular slot duration
            $slot_duration = $settings->slot_duration * 60;
        }

        //decide how many slots will be generated
        if(strtotime($hour_start)>strtotime($hour_end))
        {
            $hours = round((strtotime($hour_start) - strtotime($hour_end))/$slot_duration, 1);
        }
        else if(strtotime($hour_end)>strtotime($hour_start))
        {
            $hours = round((strtotime($hour_end) - strtotime($hour_start))/$slot_duration, 1);
        }
        else if(strtotime($hour_start)==strtotime($hour_end))
        {
            $hours = 24;
        }

        //get all bookings to block some already booked slots
        $bookings = Booking::all()->where('status', '!=',__('backend.cancelled'));

        //get all events to block some slots  - LA
		$events = Event::all()->where('is_active', '=',1);
		
		//get all session slots to block some slots  - LA
		$sessionSlots =  DB::table('session_slots')->where('booking_date','=',$event_date)->get();
		
		//$sessionSlots =  DB::table('session_slots')->where('booking_date','=',$event_date)->where('expiration_date','>=',time())->get();		
        $setting = Settings::query()->first();
		//reset the counter to disable slots
        $count_next_disabled = 0;
        //start loop for slot generation
        for($i = 0; $i < $hours; $i++)
        {
            // minutes to add in lap of each slot
            $minutes_to_add = $slot_duration * $i;
            // increment each slot by minutes_to_add
            $timeslot = date('H:i:s', strtotime($hour_start)+$minutes_to_add);
            
            //clock format choice
            if($settings->clock_format == 12)
            {
                $list_slot[$i]['slot'] = date('h:i A', strtotime($timeslot));
            }
            else
            {
                $list_slot[$i]['slot'] = date('H:i', strtotime($timeslot));
            }

            //if counter for disabling slots is not zero, block the slot as already booked
            if($count_next_disabled!=0)
            {
                $list_slot[$i]['is_available'] = false;
                $count_next_disabled--;
            }
            else
            {
                $list_slot[$i]['is_available'] = true;
            }
 
            //checking slot availability
            foreach ($bookings as $booking)
            {
               
                // Logica para que se pinten los slots cuando es por tiempo.
                if(
                    strtotime($booking->booking_date)==strtotime($event_date) && 
                    $categoryType == 1 && 
                    $booking->booking_time2 !== null &&
                    $booking->package_id == $selected_package_id
                    ) {
                    $existSlot = $this->getSlotsPerTime($booking->booking_date ,$booking->package_type_id, $booking->booking_time, $timeslot);
                    if($existSlot) {
                        $list_slot[$i]['is_available'] = false;
                    }
                }

                // Logica para que se pinten los slots cuando es Standard.
                if($categoryType == 0 && strtotime($booking->booking_date)==strtotime($event_date) && strtotime($booking->booking_time)==strtotime($timeslot))
                {
                    //put multiple booking logic

                    //one booking at one slot
                    

                    if($settings->slots_method == 1)
                    {
                        //prevent multiple bookings at same time
                        $list_slot[$i]['is_available'] = false;
                        $package_booking = Package::find($booking->package_id);
                        $package = Package::find($selected_package_id);
                        
                        if($setting->slots_with_package_duration)
                        {
                            $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                        }
                        else
                        {
                            $count_next_disabled = ($package_booking->duration / $setting->slot_duration) - 1;

                        }
                    }

                    //multiple with different package
                    
                    if($settings->slots_method == 3)
                    {
                        if($selected_package_id == $booking->package_id)
                        {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if($settings->slots_with_package_duration)
                            {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            }
                            else
                            {
                                $count_next_disabled = ($package_booking->duration / $settings->slot_duration) - 1;

                            }
                        }
                    }

                    //multiple with different category

                    if($setting->slots_method == 4)
                    {
                        if($selected_category_id == $booking->package->category->id)
                        {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if($settings->slots_with_package_duration)
                            {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            }
                            else
                            {
                                $count_next_disabled = ($package_booking->duration / $settings->slot_duration) - 1;

                            }
                            break;
                        }
                    }
                }
            }

            $list_slot[$i]['is_event'] = false;

			if ($bookingType!=2)
			{
				//$list_slot[$i]['is_blocked'] = false;

				//check slot availability against Events -- LA
				foreach ($events as $event)
				{
					if(strtotime($event->date)==strtotime($event_date) && strtotime($event->time1)<=strtotime($timeslot) && strtotime($event->time2)>=strtotime($timeslot) && $event->category_id == $selected_category_id   )
					{
							$list_slot[$i]['is_available'] = false;
							$list_slot[$i]['is_blocked'] = false;
							$list_slot[$i]['is_event'] = true;
							$list_slot[$i]['description'] = $event->description;
					}
					else
					{
							$list_slot[$i]['is_blocked'] = false;
					}
				}


				//check slot availability against SessionSlots -- LA
				foreach ($sessionSlots as $sessionSlot)
				{
                    // SessionSlots modo Standard
                    if($categoryType == 0 && strtotime($sessionSlot->booking_date)==strtotime($event_date) && strtotime($sessionSlot->booking_time)==strtotime($timeslot)) {
                        $list_slot[$i]['is_available'] = false;
                        $list_slot[$i]['is_blocked'] = true;
                        $list_slot[$i]['description'] = "PROGRESS";
                    }
                    // SessionSlots modo Por tiempo
                    else if($categoryType == 1 && strtotime($sessionSlot->booking_date)==strtotime($event_date) && $sessionSlot->booking_time2 !== null ) {
                        $existSlot = $this->getSlotsPerTime($sessionSlot->booking_date ,$sessionSlot->package_type_id, $sessionSlot->booking_time, $timeslot);
                        if($existSlot) {
                            $list_slot[$i]['is_available'] = false;
                            $list_slot[$i]['is_blocked'] = true;
                            $list_slot[$i]['description'] = "PROGRESS";
                        }
                    }
				}

				//check if slot is expired
                
				if($settings->clock_format == 12)
				{
					$current_time = date('h:i A');
				}
				else
				{
					$current_time = date('H:i');
				}

				$today_date = date('d-m-Y');
				//$today_date = date('Y-m-d');
				
				if ((strtotime( $list_slot[$i]['slot']) <= strtotime($current_time)) && ($event_date== $today_date ))
				{		
					$list_slot[$i]['is_available'] = false;
					$list_slot[$i]['is_blocked'] = false;
					$list_slot[$i]['is_expired'] = true;
				}		
			}
        }

        return view('blocks.slots', compact('list_slot', 'hours'));
    }


    public function getUpdateSlots()
    {
        $event_date = \request('event_date');
        $booking_id = \request('booking');
        $booking = Booking::find($booking_id);
        $selected_package_id = $booking->package_id;
        $selected_category_id = Package::find($selected_package_id)->category->id;

		
        $timestamp_for_event = strtotime($event_date);
        $today_number = date('N', $timestamp_for_event);

        //get related booking time for day number
        $booking_time = BookingTime::findOrFail($today_number);

        $hour_start = $booking_time->opening_time;
        $hour_end = $booking_time->closing_time;

        //decide what will be the duration of each slot
        if(config('settings.slots_with_package_duration'))
        {
            //use package duration as slot duration
            $package = Package::find($selected_package_id);
            $slot_duration = $package->duration * 60;
        }
        else
        {
            //use regular slot duration
            $slot_duration = config('settings.slot_duration') * 60;
        }

        if(strtotime($hour_start)>strtotime($hour_end))
        {
            $hours = round((strtotime($hour_start) - strtotime($hour_end))/$slot_duration, 1);
        }
        else if(strtotime($hour_end)>strtotime($hour_start))
        {
            $hours = round((strtotime($hour_end) - strtotime($hour_start))/$slot_duration, 1);
        }
        else if(strtotime($hour_start)==strtotime($hour_end))
        {
            $hours = 24;
        }

        $bookings = Booking::all()->where('status', '!=',__('backend.cancelled'));

        $count_next_disabled = 0;

        for($i = 0; $i < $hours; $i++)
        {
            // increment by 1 hour
            $minutes_to_add = $slot_duration * $i;

            // add 1 hour to each next slot
            $timeslot = date('H:i:s', strtotime($hour_start)+$minutes_to_add);

            //clock format choice
            if(config('settings.clock_format')==12)
            {
                $list_slot[$i]['slot'] = date('h:i A', strtotime($timeslot));
            }
            else
            {
                $list_slot[$i]['slot'] = date('H:i', strtotime($timeslot));
            }

            if($count_next_disabled!=0)
            {
                $list_slot[$i]['is_available'] = false;
                $count_next_disabled--;
            }
            else
            {
                $list_slot[$i]['is_available'] = true;
            }

            //checking slot availability
            //checking slot availability
            foreach ($bookings as $booking)
            {
                if(strtotime($booking->booking_date)==strtotime($event_date) && strtotime($booking->booking_time)==strtotime($timeslot))
                {
                    //put multiple booking logic

                    //one booking at one slot

                    if(config('settings.slots_method') == 1)
                    {
                        //prevent multiple bookings at same time
                        $list_slot[$i]['is_available'] = false;
                        $package_booking = Package::find($booking->package_id);
                        $package = Package::find($selected_package_id);
                        if(config('settings.slots_with_package_duration'))
                        {
                            $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                        }
                        else
                        {
                            $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;

                        }
                    }

                    //multiple with different package

                    if(config('settings.slots_method') == 3)
                    {
                        if($selected_package_id == $booking->package->id)
                        {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if(config('settings.slots_with_package_duration'))
                            {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            }
                            else
                            {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;

                            }
                        }
                    }

                    //multiple with different category

                    if(config('settings.slots_method') == 4)
                    {
                        if($selected_category_id == $booking->package->category->id)
                        {
                            //prevent multiple bookings at same time
                            $list_slot[$i]['is_available'] = false;
                            $package_booking = Package::find($booking->package_id);
                            $package = Package::find($selected_package_id);
                            if(config('settings.slots_with_package_duration'))
                            {
                                $count_next_disabled = ($package_booking->duration / $package->duration) - 1;
                            }
                            else
                            {
                                $count_next_disabled = ($package_booking->duration / config('settings.slot_duration')) - 1;

                            }
                            break;
                        }
                    }
                }
            }

        }
        return view('blocks.backendSlots', compact('list_slot', 'hours'));

    }


    public function update_booking(Request $request, $id)
    {
        $booking = Booking::find($id);
        if($booking->user->id == Auth::user()->id)
        {
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

        }

        return redirect()->route('customerBookings');

    }

    /**
     * @param BookingStep1 $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postStep1(Request $request)
    {
        $input = $request->all();
        $selectedCategoryDraw = Package::find($input['package_id'])->category->draw;
        $categoryType = Package::find($input['package_id'])->category->category_type;
        $customCategory = Package::find($input['package_id'])->category->id;
        $request->session()->put('package_id', $input['package_id']);
        $request->session()->put('selectedCategoryDraw', $selectedCategoryDraw);
        $request->session()->put('categoryType', $categoryType);
        $request->session()->put('customCategory', $customCategory);
        
        $request->session()->put('booking_type_id', '');
        if($selectedCategoryDraw == 0) {
            $request->session()->put('booking_type_id', '1');
        }

		$request->session()->put('countdown', $input['countdown']);	
        
        //return redirect()->route('getBookingType');
         return redirect()->route('loadStep2');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getBookingType()
    {    
        return view('select-booking-type');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDraws()
    {  
    //     $data = DB::select(" SELECT *
    //     FROM events e
    //     WHERE e.event_type = 2 AND e.drawtime1 <= ".$date." AND e.drawtime2 >= ".$date." ");
    // dd($data);
        //$date = Carbon::GETDATE()->format('Y-m-d H:i:s');
		//$date = Carbon::now()->format('Y-m-d H:i:s');
		$date = Carbon::now()->toDateTimeString();
        $package = Package::find(Session::get('package_id'));
        DB::table('session_slots')->where('session_email','=', Auth::user()->email)->where('booking_type', 2)->delete();

        $events = DB::select("SELECT * from events
            WHERE is_active  = 1
            AND event_type = 2
            AND category_id = ".$package->category_id."
            AND drawtime1 <= convert(varchar, getdate(), 120)
            AND drawtime2 >= convert(varchar, getdate(), 120)
        ");

        $draws = [];
        if(count($events)) {
            $draws = array();
            foreach ($events as $key => $value) {
                $newDraW = Draw::where('status',1)->where('event_id',$value->id)->first();
                if($newDraW) {
                    array_push($draws, $newDraW);
                }
            }
        }

        $data = [ 'draws' => $draws ];
        return view('blocks.draws', $data);
    }

    public function getDrawTimes() {
        return view('blocks.drawtimes');
    }

        /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getDateDraw(Request $request)
    {  
        DB::table('session_slots')->where('session_email','=', Auth::user()->email)->where('booking_type', 2)->delete();
        $data = Draw::where('id', $request['id'])->with(['event'])->first();
        $date = $data->event()->first()->date;
        $request->session()->put('draw_id', $request['id']);
        return response()->json([ 'date' => $date ]);
    }

    public function checkHour($hour){
        $list = Session::get('hours-by-date');
        if($list) {
            foreach ($list as $key => $value) {
             if($value === $hour) {
                 return true;
             } 
            }
        }
        return false;
    }

            /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getHoursByDate(Request $request)
    {  
        $array = array();
        $current = Session::get('hours-by-date');
        if($current) {
            if(count($current) < 3){
                $valid = $this->checkHour($request['hour']);
                if(!$valid) {
                    array_push($current, $request['hour'] );
                }
            }
            $array = $current;
        } else {
            if(count($array) < 3) {
                if(!$valid) {
                    array_push($array, $request['hour']);
                }      
            }
        }
        $request->session()->put('hours-by-date',  $array);
        return response()->json([ 'hours' => $array ]);
    }

    public function removeHoursByDate(Request $request) {
        $currentHours = Session::get('hours-by-date');
        $array = array();
        foreach ($currentHours as $key => $value) {
            if($value === $request['hour']) {
                unset($currentHours[$key]);
            } else {
                array_push($array, $value);
            }
        }
        $request->session()->put('hours-by-date',   $array);
        return response()->json([ 'hours' =>  $array ]);
    }

    public function checkUserDraw() {
        $drawUser = DrawRequest::where('user_id', Auth::user()->id)->where('draw_id', Session::get('draw_id'))->first();
        if($drawUser) {
        return response()->json([ 'check' =>  true ]);
        }
        return response()->json([ 'check' =>  false ]);
    }

            /**
     * @param BookingStep1 $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function setStep2(Request $request)
    {
        $input = $request->all();
		$request->session()->put('booking_type_id', $input['booking_type_id']);
        return redirect()->route('loadStep2');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStepPlayer()
    {
        //select all players of session
        $user = Auth::user();
        $exist = SessionPlayer::where('doc_id', $user->doc_id)->where('player_type', -1)->first();

        if(!$exist) {
            SessionPlayer::create([
                'doc_id' => $user->doc_id,
                'player_type' => -1,
                'session_email' => $user->email,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'phone_number' => $user->phone_number,
                'package_id' => Session::get('package_id'),
            ]);
        } else {
            SessionPlayer::where('session_email', $user->email)->update(['package_id' => Session::get('package_id')]);
            SessionAddon::where('session_email', $user->email)->update(['package_id' => Session::get('package_id')]);
        }
        $session_players = DB::table('session_players')->where('session_email','=',Auth::user()->email)->where('player_type','!=',-1)->get();
         //load step Player
        $packageNameSelected = Package::find(Session::get('package_id'))->title;
        $packageNameSelected = $packageNameSelected ? 'Paquete: '.$packageNameSelected : '';
		return view('select-booking-players', compact('session_players','packageNameSelected'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStepPlayer(Request $request)
    {
        $input = $request->all();
		$request->session()->put('countdown', $input['countdown']);	
		
        //store form input into session and load next step
        // $request->session()->put('doc_id', $input['doc_id']);
		// $request->session()->put('player_type', $input['player_type']);
		// $request->session()->put('session_email', $input['session_email']);


		//validate min Players
		
		/*
		$minPlayers = config('settings.bookingUser_minPlayers');
		$maxPlayers = config('settings.bookingUser_maxPlayers');
		
		$session_players = count(DB::table('session_players')->where('session_email','=', Auth::user()->email)->get()) + 1;
	
		echo $session_players . " vs " . $minPlayers  . " hasta " . $maxPlayers   ;
		//return redirect('/select-booking-players');

		// $session_players = DB::table('session_players')->where('session_email','=',Auth::user()->email)->get();

		//return view('select-booking-players', compact('session_players'));
		
		// die();

		if (($session_players >= $minPlayers) && ($session_players <= $maxPlayers))
		{
			//OK
			//load step 2
			return redirect('/select-booking-time');
			//return view('select-booking-time', compact('disable_days_string'));
		}
		else
		{
			if (($session_players< $minPlayers))
				echo "<center>El mínimo de participantes debe ser " . $minPlayers . "</center><br>"; 
			
			if (($session_players > $maxPlayers))
				echo "<center>El máximo de participantes debe ser " . $maxPlayers . "</center>"; 
			
			//select all players of session
			//$session_players = DB::table('session_players')->where('session_email','=',Auth::user()->email)->get();

			 //load step Player
			//return view('select-booking-players', compact('session_players'));
			return redirect('/select-booking-players');
		}
*/
        return redirect('/select-booking-time');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep2()
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

		//return view('select-booking-time', compact('disable_days_string'));

		//validate min Players
		
		$minPlayers = config('settings.bookingUser_minPlayers');
		$maxPlayers = config('settings.bookingUser_maxPlayers');
		
		$session_players = count(DB::table('session_players')->where('session_email','=', Auth::user()->email)->get()) + 1;
		//echo $session_players . " vs " . $minPlayers;
		
		//if (($session_players >= $minPlayers) && ($session_players <= $maxPlayers))
		// if (($session_players < $minPlayers) || ($session_players > $maxPlayers))
		// {
			// if (($session_players< $minPlayers))
			// echo "<font color='#ff0000'><center>El mínimo de participantes debe ser " . $minPlayers . "</center></font><br>"; 
			
			// if (($session_players > $maxPlayers))
			
			// echo "<font color='#ff0000'><center>El máximo de participantes debe ser " . $maxPlayers . "</center></font>"; 
			
			// //select all players of session
			// $session_players = DB::table('session_players')->where('session_email','=',Auth::user()->email)->get();

			 // //load step Player
			// return view('select-booking-players', compact('session_players'));
		// }
		// else
		{
			//OK
			//load step 2
			return view('select-booking-time', compact('disable_days_string'));
		}

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStep2(Request $request)
    {
        $input = $request->all();
        $setting = Settings::query()->first();
        //store form input into session and load next step
        $request->session()->put('address', $input['address']);
        $request->session()->put('event_date', $input['custom-event_date']);
        $request->session()->put('instructions', $input['instructions']);
        $request->session()->put('booking_slot', $input['booking_slot']);
		$request->session()->put('countdown', $input['countdown']);	

		//date_default_timezone_set(env('LOCAL_TIMEZONE','America/Caracas'));

		//check if logged
		//if($user = Auth::user())
		//if (!Auth::check())
			
		//se hacen las validaciones de reservas para el caso de reservas directas
		if(Session::get('booking_type_id') === "1") 
		{	
	
	
			//$todayBookings = date("d-m-Y");
			$dateBookings = $input['custom-event_date']; 

			//obviar las cancelaciones
			$bookings_count = count(DB::table('bookings')->where('booking_date','=', $dateBookings)->where('user_id','=', Auth::user()->id)->where('status','!=', __('backend.cancelled'))->get());
            //$bookings_today = Auth::user()->bookings()->where('booking_date','=',($todayBookings));
			$bookings_perday =  $setting->bookingUserPerDay;
			
			//echo $bookings_perday;
			//die();
			
			//echo Auth::user()->id . " : " . $bookings_count . " vs " . $bookings_perday . " @ " . $dateBookings;
			//exit();

			//validate as participant confirmed
			// $bookingsparticipant_count = count(DB::table('booking_players')->where('doc_id','=', Auth::user()->doc_id)->where('confirmed','=', 1)->booking->where('booking_date','=', $dateBookings)->get());
			
			$queryBookingPlayerCount = "select count(*) as cant from booking_players p join bookings b on b.id = p.booking_id where p.doc_id = '" . Auth::user()->doc_id . "' and p.confirmed=1 and b.booking_date='" . $dateBookings . "' and b.status!='" . __('backend.cancelled') . "'";	



			// $row = DB::table('booking_players')
                // ->select(DB::raw('booking_players.id as ID'))
                // ->join('bookings', 'bookings.id', '=', 'booking_players.booking_id')
                // ->where('booking_players.doc_id', '=', "'" . Auth::user()->doc_id . "'")
				// ->where('booking_players.confirmed', '=', 1)
				// ->where('bookings.booking_date', '=', "'" . $dateBookings . "'")
				// ->where('bookings.status', '!=', 'Cancelado')
                // ->get();
				
				//__('backend.cancelled')
				
			//$bookingsparticipant = count($row);
			// $row = DB::table('log_user_login')
                // ->select(DB::raw('log_user_login.Password as LogPassword'), 'user.*')
                // ->join('user', 'log_user_login.Username', '=', 'user.Username')
                // ->where('log_user_login.LoginSession', '!=', '')
                // ->groupBy('user.ID')
                // ->get();
				
			//echo $bookingsparticipant = count($row);

	
			//echo $queryBookingPlayerCount;
			require 'config.inc';
			
            $connectionInfo = array( 
                "Database"=> $database,
                "UID"=> $username, 
                "PWD"=> $password
                );
			
			$connection = sqlsrv_connect($servername, $connectionInfo); 

			// Check connection 
			if (!$connection) 
			{ 
				$has_errors = 1;	
				$err_message =  $err_message . "<br>Database connection failed."; 
				exit(); //die();
			}

			$resultqueryBookingPlayerCount = sqlsrv_query($connection, $queryBookingPlayerCount); 
			 

			if( $resultqueryBookingPlayerCount === false) {
			    die( print_r( sqlsrv_errors(), true) );
			}	

			$bookingsparticipant_count= 0;
			while( $row = sqlsrv_fetch_array( $resultqueryBookingPlayerCount, SQLSRV_FETCH_ASSOC) ) {
				 $bookingsparticipant_count = $row['cant'];
			}

			sqlsrv_free_stmt( $resultqueryBookingPlayerCount);			
			

/*
			if ($resultqueryBookingPlayerCount) 
			{ 
				$rowGroupCount = sqlsrv_num_rows($resultqueryBookingPlayerCount); 
			    //printf("Number of row in the table : " . $rowGroupCount); 
				if ($rowGroupCount>0) 
				{
					while($row = sqlsrv_fetch_array($resultqueryBookingPlayerCount)){
						$bookingsparticipant_count = $row['cant'];
					}
				}
				else
				{
					
				}
			}			
*/
			 //echo Auth::user()->id . " : $bookingsparticipant_count " . "+" . $bookings_count . " vs " . $bookings_perday . " @ " . $dateBookings;
			 //die();
			
			//check total bookings or participate per day
			if ($bookings_count + $bookingsparticipant_count < $bookings_perday)
			{
				//echo "OK";	
				//echo $todayBookings;
			}
			else
			{
				
				echo "<center>MAX RESERVACIONES POR DIA EXCEDIDO</center>";	
				//return view('custom.restricted');		
				
				echo '<script>';
				echo '			window.location.href = `custom/RestrictedUserBooking.php?type=custom&customText=MAX RESERVACIONES POR DIA EXCEDIDO`;';
			//	echo '			window.location.href = `{{ url('login') }}`;';		
				echo '			</script>';
				exit;	
			}
			//			@if(count($session_players))
			//				@foreach($session_players as $player)				
		}

		// date_default_timezone_set('America/Caracas');
		// $packageEndDate = date('Y-m-d H:i:s', strtotime('+' . config('settings.bookingTimeout') . ' minute'));
        //create session_slot
        $tennisSlot = json_decode($input['tennis_slot']);
        $package_id = Session::get('package_id');
        $packageType = $input['package-type'] ? $input['package-type'] : null; // Validar package_type 
        $bookingTime2 = null; 

        if($tennisSlot !== null) {

            $input['booking_slot'] = $tennisSlot[0];
            $bookingTime2 = end($tennisSlot);
            Session::put('tennisSlots',$tennisSlot);
            Session::put('booking_slot',$input['booking_slot']);
        }
        Session::put('packageType',$packageType);
        Session::put('booking_time2',$bookingTime2);
        
        
        if(Session::get('booking_type_id') === "1") {
            SessionSlot::create([
                'session_email' =>  Auth::user()->email ,
                'booking_date' =>  $input['custom-event_date'] ,
                'booking_time' =>  $input['booking_slot'] ,
                'booking_type' =>  Session::get('booking_type_id'),
                'package_id' =>  $package_id,
                'package_type_id' =>  $packageType,
                'booking_time2' =>  $bookingTime2,
            ]);
        }
        if(Session::get('booking_type_id') === "2") {
            $hourSlots = $input['draw_booking_slot'];
            $hourSlots = json_decode($hourSlots);
            foreach ($hourSlots as $key => $value) {
                SessionSlot::create([
                    'session_email' =>  Auth::user()->email ,
                    'booking_date' =>  $input['custom-event_date'] ,
                    'booking_time' =>  $value ,
                    'booking_type' =>  Session::get('booking_type_id'),
                    'package_type_id' =>  $packageType,
                    'booking_time2' =>  $bookingTime2,
                ]);
            }
        }

		//update expiration date
	
		$param =  $setting->bookingTimeout;

		// $sql2="UPDATE session_slots SET expiration_date=TIMESTAMPADD(MINUTE, " . $param  .  " , created_at) WHERE session_email='" .  Auth::user()->email  .  "' and booking_date='" .  Session::get('event_date')  . "' AND booking_time='" .  Session::get('booking_slot')  . "'"  ;
		
		$sql2="UPDATE session_slots SET created_at=GETDATE(), updated_at=GETDATE(),  expiration_date=    dateadd(MINUTE, " . $param  .  " , GETDATE()) WHERE session_email='" .  Auth::user()->email  .  "' and booking_date='" .  $input['custom-event_date']  . "' AND booking_time='" .  $input['booking_slot']  . "'"  ;
		
		
		
        $result = sqlsrv_query($connection, $sql2);
        
        return redirect('/select-booking-players');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postStep3(Request $request)
    {
        $request->session()->put('countdown', $input['countdown']);
        return redirect('/finalize-booking');
    }

    public function getParams() {
        $categoryType = Session::get('categoryType');
        $settings = Settings::query()->first();

        $params = (object) [
            'booking_min' => null,
            'booking_max' => null,
            'player_min' => null,
            'player_max' =>  null,
            'guest_min' =>  null,
            'guest_max' =>  null,
            'bookingUser_maxPerDay' => null,
            'bookingUser_maxPerWeek' => null,
            'bookingUser_maxPerMonth' => null,
            'bookingGuest_maxPerDay' => null,
            'bookingGuest_maxPerWeek' => null,
            'bookingGuest_maxPerMonth' => null,
        ];

        switch ($categoryType) {
            case "0":
                //Standard
                $params->booking_min = $settings->bookingUser_minPlayers;
                $params->booking_max = $settings->bookingUser_maxPlayers;
                $params->player_min = 1;
                $params->player_max = $settings->bookingUser_maxPlayers;
                $params->guest_min = $setting->bookingUser_MinGuests;
                $params->guest_max = $settings->bookingUser_maxGuests;
                $params->bookingUser_maxPerDay = $settings->bookingUserPlayPerDay;
                $params->bookingUser_maxPerWeek = $settings->bookingUserPlayPerWeek;
                $params->bookingUser_maxPerMonth = $settings->bookingUserPlayPerMonth;
                $params->bookingGuest_maxPerDay = $settings->bookingGuestPlayPerDay;
                $params->bookingGuest_maxPerWeek = $settings->bookingGuestPlayPerWeek;
                $params->bookingGuest_maxPerMonth = $settings->bookingGuestPlayPerMonth;
                break;
            case "1":
                //Per Time

                // Consultar parametros para el Tipo de Paquete
                $selectedPackageTypeId = Session::get('selectedPackageType');
                $selectedPackageTypeId = $selectedPackageTypeId->id;
                $packageType = PackagesType::find($selectedPackageTypeId);
                $params->booking_min = $packageType->booking_min;
                $params->booking_max = $packageType->booking_max;
                $params->player_min = $packageType->player_min;
                $params->player_max = $packageType->player_max;
                $params->guest_min = $packageType->guest_min;;
                $params->guest_max = $packageType->guest_max;;
                $params->bookingUser_maxPerDay = $settings->bookingUser_maxTimePerDay;
                $params->bookingUser_maxPerWeek = $settings->bookingUser_maxTimePerWeek;
                $params->bookingUser_maxPerMonth = $settings->bookingUser_maxTimePerMonth;
                $params->bookingGuest_maxPerDay = $settings->bookingGuest_maxTimePerDay;
                $params->bookingGuest_maxPerWeek = $settings->bookingGuest_maxTimePerWeek;
                $params->bookingGuest_maxPerMonth = $settings->bookingGuest_maxTimePerMonth;
                break;
        }

        return $params;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadStep3()
    {
        
        $params = $this->getParams();
        $userEmail = Auth::user()->email;
        $message = "";
        // Validacion Reserva
        $cant = SessionPlayer::where('session_email', $userEmail)->where('package_id', Session::get('package_id'))->count();
        
        if($cant !== null && $cant < $params->booking_min) {
            $message .= "<br> El mínimo de participantes debe ser " . $params->booking_min . "";
        }

        // Validacion Socios
        $cant = SessionPlayer::where('session_email', $userEmail)->where('package_id', Session::get('package_id'))->whereIn('player_type', [0,-1])->count();
        if($cant !== null && $cant < $params->player_min) {
            $message .= "<br> El mínimo de Socios debe ser " . $params->player_min . "";
        }

        // Validacion Invitadoss
        $cant = SessionPlayer::where('session_email', $userEmail)->where('package_id', Session::get('package_id'))->where('player_type', 1)->count();
        if($cant !== null && $cant < $params->guest_min) {
            $message .= "<br> El mínimo de Invitados debe ser " . $params->guest_min . "";
        }

        // Si existe mensaje de error se envia a la plantilla blade de participantes
        if($message !== '') {
            echo "<font color='#ff0000'><center>".$message."</center></font><br>";
            //select all players of session
            $session_players = SessionPlayer::where('session_email', $userEmail)->where('package_id', Session::get('package_id'))->where('player_type','!=', -1)->get();;
            //load step Player
           return view('select-booking-players', compact('session_players'));
        }

		
        $package_id = Session::get('package_id');
        $package = Package::find($package_id);
        $category_id = $package->category_id;

        //select all addons of category
        $addons = Category::find($category_id)->addons()->get();
        $session_addons = DB::table('session_addons')->where('session_email','=',Auth::user()->email)->get();
        $selectedPlayer = Session::get('selectedPlayer');
        foreach ($addons as $key => $value) {
            $sessionAddon = SessionAddon::where('addon_id', $value->id)->where('doc_id', $selectedPlayer)->where('package_id',$package_id)->where('session_email',Auth::user()->email)->first();
            if($sessionAddon){
                $addons[$key]->cant = $sessionAddon->cant;
                $addons[$key]->buttonText = __('app.update_service_btn');
                $addons[$key]->showDelete = 'show';
            } else {
                $addons[$key]->cant = 1;
                $addons[$key]->buttonText = __('app.add_service_btn');
                $addons[$key]->showDelete = 'hidde';
            }
        }
        $packageNameSelected = Package::find(Session::get('package_id'))->title;
        $packageNameSelected = $packageNameSelected ? 'Paquete: '.$packageNameSelected : '';
        return view('select-extra-services', compact('addons', 'session_addons','selectedPlayer', 'packageNameSelected'));
    }

    /**
     * @param Request $request
     */
    public function checkUserPackageParameters(Request $request) {

        $settings = Settings::query()->first();;
        $player = auth()->user();
        $package = $request['package_id'];
        $categoryType = Package::find($package)->category->category_type;

        $fecha = Carbon::now()->format('d-m-Y');
        $params = array( $categoryType, 1, $player->doc_id, $fecha);
            
        $query = 'exec CalcularParticipacionesPorFecha ?,?,?,?';
        $data = \DB::select($query,$params);
        $errMessage = '';
        $unidadmedida = '';
        if($categoryType == 0) $unidadmedida= 'partidas';
		if($categoryType == 1) $unidadmedida= 'minutos';
        $messagePerDayWeekMonth = "No puede exceder el numero de ".$unidadmedida."";

        $conditionPerDay = $categoryType == 0 ? $settings->bookingUserPlayPerDay : $settings->bookingUser_maxTimePerDay;
		$conditionPerWeek = $categoryType == 0 ? $settings->bookingUserPlayPerWeek : $settings->bookingUser_maxTimePerWeek;
		$conditionPerMonth = $categoryType == 0 ? $settings->bookingUserPlayPerMonth : $settings->bookingUser_maxTimePerMonth;

        if($data) {
            $calculoDia = (int)$data[0]->dia ? (int)$data[0]->dia : 0;
			$calculoSemana = (int)$data[0]->semana ? (int)$data[0]->semana: 0;
            $calculoMes = (int)$data[0]->mes ? (int)$data[0]->mes : 0;
            if ($calculoDia >= $conditionPerDay) {
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por día. <br>";
            }
    
            if ($calculoSemana >= $conditionPerWeek) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Semana. <br>";
            }
    
            if ($calculoMes >= $conditionPerMonth) { 
                $errMessage = $errMessage ." ". $messagePerDayWeekMonth." por Mes.";
            }
            $sDebugSP  = $query . "--> Dia=%s, Semana=%s, Mes=%s";
            $sDebugSP = str_replace("?","%s", $sDebugSP );
            $sDebugSP = sprintf($sDebugSP,$categoryType, 1, $player->doc_id, $fecha , $calculoDia, $calculoSemana, $calculoMes);
            Log::info($sDebugSP);
        }
        if($errMessage !== '') {
            return response()->json([ 
                'success' => $errMessage !== '' ? true : false,
                'message' => $errMessage,
            ]);
        } 
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function loadFinalStep()
    {
        $event_address = str_replace(' ', '+', Session::get('address'));
        $category = Package::find(Session::get('package_id'))->category->title;
        $package = Package::find(Session::get('package_id'));
        $session_addons = DB::table('session_addons')->where('session_email','=',Auth::user()->email)->get();
        $packageType = $packageType ? $packageType->title : '';

        $sessionAddons = \DB::select("SELECT DISTINCT addon_id FROM session_addons where session_email = '".auth()->user()->email."' and package_id = '".Session::get('package_id')."'  ");

       
        $string = '';
        foreach ($sessionAddons as $key => $element) {

            $addonParameters = AddonsParameter::where('addon_id', $element->addon_id)->where('package_id', Session::get('package_id'))->first();
            $AddonCant = SessionAddon::where('session_email', auth()->user()->email)->where('addon_id',$element->addon_id)->sum('cant');

            if((int)$AddonCant < (int)$addonParameters->booking_min) {
                $string .= '<br> Para el Addon: '.$addonParameters->addon->title.', solo se permite seleccionar minimo '.$addonParameters->booking_min.' para la reserva ';
            }
        }

        if($string !== '') {
            $package_id = Session::get('package_id');
            $package = Package::find($package_id);
            $category_id = $package->category_id;
    
            //select all addons of category
            $addons = Category::find($category_id)->addons()->get();
            $session_addons = DB::table('session_addons')->where('session_email','=',Auth::user()->email)->get();
            $selectedPlayer = Session::get('selectedPlayer');
            foreach ($addons as $key => $value) {
                $sessionAddon = SessionAddon::where('addon_id', $value->id)->where('doc_id', $selectedPlayer)->where('package_id',$package_id)->where('session_email',Auth::user()->email)->first();
                if($sessionAddon){
                    $addons[$key]->cant = $sessionAddon->cant;
                    $addons[$key]->buttonText = __('app.update_service_btn');
                    $addons[$key]->showDelete = 'show';
                } else {
                    $addons[$key]->cant = 1;
                    $addons[$key]->buttonText = __('app.add_service_btn');
                    $addons[$key]->showDelete = 'hidde';
                }
            }
            echo "<font color='#ff0000'><center>$string</center></font><br>";
            return view('select-extra-services', compact('addons', 'session_addons','selectedPlayer'));
        }



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
            $total_with_gst = round($total_with_gst,2);
        }

        $packageType = Session::get('selectedPackageType');
        $packageType = $packageType ? $packageType->title : '';


        return view('finalize-booking', compact('event_address', 'category',
            'package', 'session_addons', 'total', 'total_with_gst', 'gst_amount','packageType'));
    }

    /**
     *
     * Thank you - payment completed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function thankYou()
    {
        return view('thank-you');
    }

    /**
     * Payment failed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function paymentFailed()
    {
        return view('payment-failed');
    }

    /**
     *
     * Show booking to customer
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $booking = Booking::find($id);

        //checking booking date to allow update or cancel
        $days_limit_to_update = config('settings.days_limit_to_update') * 86400;
        $days_limit_to_cancel = config('settings.days_limit_to_cancel') * 86400;
        $today = date('Y-m-d');

        if(strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_update)
        {
            $allow_to_update = true;
        }
        else
        {
            $allow_to_update = false;
        }

        if(strtotime($booking->booking_date) - strtotime($today) >= $days_limit_to_cancel)
        {
            $allow_to_cancel = true;
        }
        else
        {
            $allow_to_cancel = false;
        }

        return view('customer.bookings.view' , compact('booking','allow_to_update', 'allow_to_cancel'));
    }

    /**
     *
     * Remove addon from list of booking services
     */
    public function removeFromList(Request $request)
    {
        $addon_id = $request['addon_id'];
        $doc_id = $request['doc_id'];
        $session_email = $request['session_email'];

        DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email','=', $session_email)->where('doc_id','=' ,$doc_id)->delete();

    }


    /**
     *
     * check if addon is added in list of booking services
     */
    public function checkIfAdded($addon_id,$session_email)
    {
        $row = DB::table('session_addons')->where('addon_id', '=', $addon_id)->where('session_email','=',$session_email)->get();
        if(count($row)==0)
        {
            return 0;
        }
        else
        {
            return 1;
        }
    }


    /**
     *
     * load booking update view for user
     */

    public function update($id)
    {
        $booking = Booking::find($id);

        $cancel_request = $booking->cancel_request()->first();

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

        if($booking->user->id == Auth::user()->id
            && $booking->status != __('backend.cancelled')
            && count($cancel_request)==0)
        {
            return view('customer.bookings.update', compact('booking', 'disable_days_string'));
        }
        else
        {
            return view('errors.404');
        }
    }

    public function getExtraServiceParticipants() {
        $package_id = Session::get('package_id');
        $user = auth()->user();
        $arrayParticipants = array();
        $user->isUser = true;
        array_push($arrayParticipants, $user);
        $participants = SessionPlayer::where('session_email', $user->email)->where('player_type','!=', -1)->get();
        foreach ($participants as $key => $value) {
            $participants[$key]->isUser = false;
            array_push($arrayParticipants, $value);
        }
        foreach ($arrayParticipants as $key => $value) {
            $addons = SessionAddon::where('package_id', $package_id)->where('doc_id', $value->doc_id)->with(['addon'])->get();
            if($addons) {
                $arrayParticipants[$key]->addons = $addons;
            } else {
                $arrayParticipants[$key]->addons = [];
            }
        }
        return response()->json([ 'success' => true, 'data' => $arrayParticipants ]);
    }

    public function setParticipant(Request $request) {
        Session::put('selectedPlayer',$request['doc_id']);
        return response()->json([ 'success' => true ]);
    }

    public function getPackageType() {
        $packageId = Session::get('package_id');
        $selectedPackageType = Session::get('selectedPackageType');
        $packageTypes = [];
        $category = Package::where('id',$packageId)->with(['category'])->first();
        if($category && $category->category()->first()->category_type == 1) {
            $packageTypes = PackagesType::where('package_id', $packageId)->get();
        }
        return response()->json([ 'success' => true, 'data' => $packageTypes, 'selectedPackageType' => $selectedPackageType, 'package' => $selectedPackage ]);
    }

    public function setPackageType(Request $request) {
        $packageType = PackagesType::find($request['id']);
        $selectedPackage = Package::find($packageType->package_id);
        Session::put('selectedPackageType', $packageType);
        return response()->json([ 'success' => true, 'data' => $packageType, 'package' => $selectedPackage ]);
    }

    // public function buildHours($array, $start, $end) {
    //     $parseHour = DateTime::createFromFormat('h:ia', $start);
    //     $parseHour = $parseHour->format('H:i:s');
    //     if($start ===  $end) {
    //         return $array;
    //     }
    //     $nextHour = Carbon::parse($parseHour)->addMinutes(30)->format('g:i A');
    //     array_push($array, [ 'hour' => $nextHour]);
    //     $this->buildHours($array, $nextHour, $end);
        
    // }

    public function checkAvailablePackage($package, $hour) {

        $bookings = Booking::all()->where('status', '!=',__('backend.cancelled'));

    }

    public function buildHours($hora_inicio, $hora_fin, $category , $date , $intervalo = 30) {
        
        $settings = Settings::query()->first();
        $hora_inicio = new DateTime( $hora_inicio );
        $hora_fin    = new DateTime( $hora_fin );
        $hora_fin->modify('+1 second'); // Añadimos 1 segundo para que muestre $hora_fin
        
        // Si la hora de inicio es superior a la hora fin
        // añadimos un día más a la hora fin
        if ($hora_inicio > $hora_fin) {
            $hora_fin->modify('+1 day');
        }
        
        // Establecemos el intervalo en minutos
        
        $intervalo = new DateInterval('PT'.$intervalo.'M');
        
        // Sacamos los periodos entre las horas
        $periodo   = new DatePeriod($hora_inicio, $intervalo, $hora_fin);
        $packages = Package::where('category_id', $category)->get();
        $events = Event::all()->where('is_active', '=',1);
        $categoryType = Category::find($category); 
        $arrayHours = array();
        $sessionSlots =  SessionSlot::where('booking_date',$date)->get();
        $currentTime = $settings->clock_format == 12 ? date('h:i A') : date('H:i');
        $today = date('d-m-Y');
        foreach( $periodo as $hora ) {
            // Guardamos las horas intervalos
            $currentHour = $hora->format('H:i:s');
            $arrayAvailablePackages = array();
            $bookings = Booking::all()->where('status', '!=',__('backend.cancelled'));
            foreach ($packages as $key => $package) {
                array_push($arrayAvailablePackages, (object)[ 
                    'id' => $package->id, 
                    'title' => $package->title, 
                    'available' => true,
                    'blocked' => false,
                    'expired' => false,
                    'event' => false,
                    ]);        
            }
            array_push($arrayHours, (object)[ 'hour' => $hora->format('H:i:s') , 'packages' => $arrayAvailablePackages ]);
            //$horas[] =  $hora->format('H:i:s');
        }

        foreach ($arrayHours as $keyHours => $value) {
            foreach ($value->packages as $keyPackages => $package) {
                foreach ($bookings as $keyBookings => $booking) {
                    if($booking->booking_time2 !== null && $booking->booking_date == $date && $booking->package_id == $package->id ){
                        $existSlot = $this->getSlotsPerTime($booking->booking_date ,$booking->package_type_id, $booking->booking_time, $value->hour);
                        if($existSlot) {
                            $arrayHours[$keyHours]->packages[$keyPackages]->available = false;
                        }

                    }
                }

                foreach ($events as $keyEvents => $event) {
                    //dd('$event->date '.$event->date.' $date '.$date.' package'.$package->title);
					if( 
                        strtotime($event->date) == strtotime($date) && 
                        strtotime($event->time1) <= strtotime($value->hour) && 
                        strtotime($event->time2) >= strtotime($value->hour)
                        ){
                            $arrayHours[$keyHours]->packages[$keyPackages]->available = false;
                            $arrayHours[$keyHours]->packages[$keyPackages]->event = true;
                            $arrayHours[$keyHours]->packages[$keyPackages]->blocked = false;
					}
				}

                foreach ($sessionSlots as $keyBookings => $sessionSlot) {
                    if($sessionSlot->booking_time2 !== null && $sessionSlot->booking_date == $date && $sessionSlot->package_id == $package->id ){
                        $existSlot = $this->getSlotsPerTime($sessionSlot->booking_date ,$sessionSlot->package_type_id, $sessionSlot->booking_time, $value->hour);
                        if($existSlot) {
                            $arrayHours[$keyHours]->packages[$keyPackages]->blocked = true;
                        }

                    }

                }

                if ((strtotime($value->hour) <= strtotime($currentTime)) && ($date == $today )) {
                    $arrayHours[$keyHours]->packages[$keyPackages]->available = false;	
                    $arrayHours[$keyHours]->packages[$keyPackages]->blocked = false;	
                    $arrayHours[$keyHours]->packages[$keyPackages]->expired = true;	
                }
           }

        }
        
        return $arrayHours;
    }

    public function getBookingCategoryCalendar(Request $request) {
        $packages = Package::where('category_id', $request['category'])->get();

        $hoursCondition = DB::select("  SELECT  min(tp.opening_time) as minimo,max(tp.closing_time) as maximo
            FROM booking_times_packages tp, packages p, categories c
            WHERE c.id=p.category_id  
            AND tp.package_id=p.id
            AND c.id= ".$request['category']."
            AND tp.[number]= ".$request['number']."
        ");
        $hoursCondition = $hoursCondition[0];

        $minimo = DateTime::createFromFormat('h:ia', $hoursCondition->minimo);
        $minimo = $minimo->format('H:i:s');

        $maximo = DateTime::createFromFormat('h:ia', $hoursCondition->maximo);
        $maximo = $maximo->format('H:i:s');

        $interval = DB::select("SELECT top 1  p.duration
        from  packages p, categories c
        where c.id=p.category_id  
        and c.id = ".$request['category']." ");
        $interval = $interval[0];
        $hours = $this->buildHours($minimo, $maximo, $request['category'], $request['date'], $interval->duration);

        return response()->json([
            'packages' => $packages,
            'schedule' => $hours,
        ]);
    }

}