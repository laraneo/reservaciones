<?php

namespace App\Http\Controllers;

use App\Booking;
use App\CancelRequest;
use App\Mail\AdminCancellationNotification;
use App\Mail\CancellationReceived;
use App\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
// use Illuminate\Support\Facades\DB;

class CancelRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id = NULL)
    {
		$compare_op = '>=';
		if (isset($id) && ($id != NULL)) {
			if ($id == 1) {
				$compare_op = '<';   // Solicitud de Cancelación de Reservas Históricas
			}
			else {
				$compare_op = '>=';  // Solicitud de Cancelación de Reservas Corrientes
			}
		}
		// $compare_op = '<';
		
		// Reservaciones corrientes son aquellas en las booking_date son de hoy (o hace 2 días) en adelante
		// Reservaciones históricas son aquellas en las booking_date son de ayer (o hace 3 días) hacia atrás
		
		//Forma 0: Mostrar todas las solicitudes de cancelación <-- Es ineficiente para la interfaz del Administrador
		//$cancel_requests = CancelRequest::all();
		
        $currentdateBookings = date("Y-m-d");
		/// Forma 1: Funciona técnicamente pero no acorde a las reglas de negocio, 
		// ya que puede omitir reservaciones futuras de cancelaciones pasadas
		// $cancel_requests = CancelRequest::all()->where('created_at', $compare_op , $currentdateBookings);	
        
        // Forma 1.5: Igual que 1 pero restándole el número días en que el usuario puede cancelar  
		$days_back = config('settings.bookingUser_maxDays');
		if ($days_back > 0)
			$date = date_sub( date_create($currentdateBookings), date_interval_create_from_date_string($days_back . " day" . ($days_back==1 ? "" : "s")));
		else
			$date = date_create($currentdateBookings);
		
		$currentdateBookings = date_format($date, "Y-m-d"); 
		
		$cancel_requests = CancelRequest::all()->where('created_at', $compare_op , $currentdateBookings);	
        
		// Forma 2: Usando el Modelo CancelRequest usando la relación mediante función booking(), pero da error Laravel: booking no existe ??!!
		//$cancel_requests = CancelRequest::all()->booking()->where('booking_date', $compare_op , $currentdateBookings);	
        
		// Forma 3: Usando el Modelo Booking para luego obtener los CancelRequests, pero da error Laravel: cancel_request no existe??!! 
		//$cancel_requests = Booking::all()->where('booking_date', $compare_op, $currentdateBookings)->cancel_request()->get();	

		// Forma 4: Usar una vista SQL que haga el join de cancel_requests con bookings, falla porque no devuelve el Modelo CancelRequest
		//$cancel_requests = DB::table('vw_cancel_request_booking')->where('booking_date', $compare_op , $currentdateBookings);	
		//$cancel_requests = CancelRequest->where('booking_date', $compare_op , $currentdateBookings);	
        
		// Forma 5: Usar una función que devuelva las booking si están vigentes (corrientes) o vencidos (históricos), pero da error Laravel: current_bookings no existe??!!	
        //$cancel_requests = CancelRequest::all()->current_bookings($compare_op, $currentdateBookings);
        
		return view('cancel_requests.index', compact('cancel_requests'));
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
        $input = $request->all();
        $input['status'] = __('backend.pending');
        CancelRequest::create($input);

        Session::flash('cancel_request_received', __('backend.cancel_request_received'));

        $booking = Booking::find($input['booking_id']);
        $admin = Role::where('name','Administrador')->with('users')->first();
        $admin = $admin->users()->get();

        try {
            Mail::to($request->user())->send(new CancellationReceived($booking));
            foreach($admin as $recipient)
            {
                Mail::to($recipient)->send(new AdminCancellationNotification($booking , $recipient));
            }
        } catch(\Exception $ex) {
            //do nothing
        }

        return redirect()->route('showBooking', $input['booking_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
	 * 
	 * GC: Usado como atajo para llamar a index con valor del parámetro id que debería ser 1
     */
	 
    public function show($id)
    {
        //
		return $this->index($id);
		// return $this->index(1);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $cancel_request  = CancelRequest::find($id);

        $cancel_request->update($input);

        Session::flash('cancel_request_updated', __('backend.cancel_request_updated'));

        return redirect()->route('cancel-requests.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cancel_request = CancelRequest::find($id);
        $cancel_request->delete();

        Session::flash('cancel_request_deleted', __('backend.cancel_request_deleted'));

        return redirect()->route('cancel-requests.index');
    }

}
