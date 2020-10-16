<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\User;

class CustomLoginController extends Controller
{


    /**
     * Forced login.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $docId =  $request['doc_id'];
        $token = $request['token'];

        $user = User::where('doc_id', $docId)->where('token', $token)->first();
        if($user) {
            Auth::login($user);
        }
        return redirect()->route('home',['externalLogin' => true]);  
    }

    public function customLogout() {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');  
    }

    public function forcedLogout(Request $request) {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');  
    }

}
