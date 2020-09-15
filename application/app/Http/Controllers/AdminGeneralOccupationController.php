<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Category;
use App\Settings;

class AdminGeneralOccupationController extends Controller
{

/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::query()->where('category_type', 1)->get();
        //return response()->json([ 'success' => true, 'dates' => $dates ]);
        return view('general_occupation.index', compact('dates','categories'));
    }

    public function getSelectDays() {
        $settings = Settings::query()->first();
        $dates = array(); 
        $maxDays = $settings->bookingUser_maxDays + 1;
        for ($i=0; $i < $maxDays ; $i++) {
            if($i == 0) {
                array_push($dates, [ 'date' => Carbon::now() ]);
            } else {
                array_push($dates, [ 'date' => Carbon::now()->addDay($i) ]);
            }      
        }
        return response()->json([ 'success' => true, 'dates' => $dates ]);
    }


}
