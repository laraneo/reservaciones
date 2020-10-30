<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Category;
use App\Settings;
use App\Booking;
use App\Package;

class AdminStarterController extends Controller
{

/**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::query()->where('category_type', 1)->get();
        //return response()->json([ 'success' => true, 'dates' => $dates ]);
        return view('starter-report.index', compact('dates','categories'));
    }

    public function getBookingByPackage($package, $bookingDate) {
        $bookings = Booking::query()->select(\DB::raw('*, RIGHT(booking_time,2) as meridian, LEFT(booking_time,5) as time1'))->where('booking_date', $bookingDate)->where('package_id', $package)->with([
            'bookingplayers' => function($q) {
                $q->with('UserName');
        } ])->orderBy('meridian', 'asc')->orderBy('time1', 'asc')->get();
        return $bookings;
    }

    public function getSchedulePackages(Request $request) {
        $category = $request['category'];
        $bookingDate = $request['bookingDate'];
        $packages = Package::where('category_id', $category)->get();
        $bookings = array();
        foreach ($packages as $key => $package) {
            $newBooking = $this->getBookingByPackage($package->id, $bookingDate);
            if(count($newBooking)) {
                $newPackage = [ 'package' => $package, 'bookings' => $newBooking ];
                array_push($bookings, $newPackage);
            }
        }

        
        return count($bookings) ? $bookings : [];
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
