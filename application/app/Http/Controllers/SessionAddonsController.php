<?php

namespace App\Http\Controllers;

use App\SessionAddon;
use App\SessionPlayer;
use App\AddonsParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SessionAddonsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Session Addon Controller
    |--------------------------------------------------------------------------
    | This controller acts as an auxiliary controller to add or remove addons
    | during booking process.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $input['package_id'] = Session::get('package_id');
        $addonParameters = AddonsParameter::where('addon_id', $input['addon_id'])->where('package_id', Session::get('package_id'))->first();
        $playerExist = SessionAddon::where('doc_id', $input['doc_id'])->where('addon_id',$input['addon_id'])->first();
        $sessionPlayer = SessionPlayer::where('doc_id',$input['doc_id'])->where('package_id', Session::get('package_id'))->first();
        $AddonCant = SessionAddon::where('session_email', auth()->user()->email)->where('addon_id',$input['addon_id'])->sum('cant');
        $min = 0;
        $max = 0;
        $isUser = auth()->user()->doc_id == $input['doc_id'] ? true : false;
        $playerTypeName = $isUser || $sessionPlayer->player_type == 0 ? 'Socio' : 'Invitado';
        $playerName = $playerTypeName.' '.$sessionPlayer->first_name.' '.$sessionPlayer->last_name;
        if($isUser || $sessionPlayer->player_type == 0) {
            $min = $addonParameters->player_min;
            $max = $addonParameters->player_max;
        }

        if(!$isUser && $sessionPlayer && $sessionPlayer->player_type == 1) {
            $min = $addonParameters->guest_min;
            $max = $addonParameters->guest_max;
        }

        if($max == 0) {
            return response()->json([ 
                'success' => false,
                'message' => '<strong>'.$playerName.'</strong>, no tiene permitido seleccionar el Addon: <strong>'.$addonParameters->addon->title.'</strong>',
            ]);
        }

        if($AddonCant >= $addonParameters->booking_max) {
            return response()->json([ 
                'success' => false,
                'message' => 'Para el Addon: '.$addonParameters->addon->title.', solo se permite seleccionar maximo '.$addonParameters->booking_max.' para la reserva ',
            ]);
        }

        if($addonParameters && $input['cant'] >= $min && $input['cant'] <= $max) {
            if($playerExist) {
                SessionAddon::where('doc_id', $playerExist->doc_id)->where('addon_id', $playerExist->addon_id)->update(['cant' => $input['cant']]);
            } else {
                SessionAddon::create($input);
            }
            return response()->json([ 
                'success' => true,
                'message' => 'Addon Included',
            ]);
        } else {
            return response()->json([ 
                'success' => false,
                'message' => 'Para el Addon: '.$addonParameters->addon->title.', solo se permite seleccionar minimo '.$min.' y maximo '.$max,
            ]);
        }     
    }

    public function checkAddonParameterByPlayer($player) {
        $addonParametersByPackage = AddonsParameter::where('package_id', Session::get('package_id'))->get();
        $message = '';
        $type = $player->player_type == -1 || $player->player_type == 0 ? 'Socio' : 'Invitado';
        $name = $type.' '. $player->first_name.' '.$player->last_name;
        foreach ($addonParametersByPackage as $key => $addon) {
            $min = null;
            if($player->player_type == -1 || $player->player_type == 0) $min = $addon->player_min;
            if($player->player_type == 1) $min = $addon->guest_min;
            $playerErrorMessage = '* Para el Addon: <strong>'.$addon->addon->title.'</strong>, debe seleccionar minimo '.$min.'<br>';
            if($min > 0) {
                $addonByPlayer = SessionAddon::where('session_email', auth()->user()->email)->where('addon_id', $addon->addon_id )->where('doc_id',$player->doc_id)->first();
                if($addonByPlayer) {
                    if($addonByPlayer->cant < $min ) $message .= $playerErrorMessage;
                } else {
                    $message .= $playerErrorMessage;
                }
            }

        }
        $body = '
        <div>
        <div style="font-weight: bold">'.$name.'</div>
        <div>'.$message.'</div>
        </div>
        ';
        $message = $message !== '' ? $body : '';
        return $message;
    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function checkBookingAddons(Request $request) {
        

        $sessionAddons = \DB::select("SELECT DISTINCT addon_id FROM session_addons where session_email = '".auth()->user()->email."' and package_id = '".Session::get('package_id')."'  ");

       
        $string = '';

        $addonParametersByPackage = AddonsParameter::where('package_id', Session::get('package_id'))->get();

        foreach ($addonParametersByPackage as $key => $addon) {
            $min = $addon->booking_min;
            $bookinMessage = 'Para el Addon: <strong>'.$addon->addon->title.'</strong>, seleccionar minimo '.$min.' para la reserva <br> ';
            if($min > 0) {
                $addonCant = SessionAddon::where('session_email', auth()->user()->email)->where('addon_id',$addon->addon_id)->sum('cant');
                if($addonCant) {
                    if((int)$addonCant < (int)$min) $string .= $bookinMessage;  
                } else {
                    $string .= $bookinMessage;
                }
            }

        }

        $players = SessionPlayer::where('session_email', auth()->user()->email)->get();
        foreach ($players as $key => $player) {
            $string .= $this->checkAddonParameterByPlayer($player);
        }



        return response()->json([ 
            'success' => $string !== '' ? true : false,
            'message' => $string,
            'data' => $sessionAddons,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeAddonByParticipant(Request $request)
    {
        SessionAddon::destroy($request['id']);
        return response()->json([ 'success' => true ]);
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getTotal()
    {
        $userEmail = auth()->user()->email;
        $package_id = Session::get('package_id');
        $addons = \DB::select("SELECT sum(se.cant) as total, a.title 
        from session_addons se, addons a
        WHERE a.id = se.addon_id
        AND se.session_email = '".$userEmail."'
        AND se.package_id = ".$package_id."
        group by se.addon_id , a.title ");;
        return response()->json([ 'success' => true, 'addons' => $addons ]);
    }


        /**
     * Remove the specified resource by participant from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        SessionAddon::destroy($id);
        return redirect()->route('loadFinalStep');
    }
}
