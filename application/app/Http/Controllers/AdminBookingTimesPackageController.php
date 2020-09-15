<?php

namespace App\Http\Controllers;

use App\Category;
use App\Package;
use App\BookingTimesPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminBookingTimesPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = $request['category'];
        $queryPackage = $request['package'];
        $booking_times = [];
        $packages = [];
        if($category && $category !== '') {
            $packages = Package::where('category_id',$category)->get();
            if($queryPackage && $queryPackage !== '') {
                $booking_times = BookingTimesPackage::where('package_id', $queryPackage)->get();
            }
        }
        
        $categories = Category::all();
        $selectedCategory = $category && $category !== '' ? $category : '';
        $selectedPackage = $queryPackage && $queryPackage !== '' ? $queryPackage : '';
        return view('settings.bookingTimesPackage', compact('booking_times','categories','selectedCategory','packages','selectedPackage'));
    }

            /**
     * Generate Days.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateDays(Request $request)
    {
        $data = [
            [ 'day' => 'Lunes', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 1 ],
            [ 'day' => 'Martes', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 2 ],
            [ 'day' => 'Miercoles', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 3 ],
            [ 'day' => 'Jueves', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 4 ],
            [ 'day' => 'Viernes', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 5 ],
            [ 'day' => 'Sabado', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 6 ],
            [ 'day' => 'Domingo', 'opening_time' => '06:00 AM', 'closing_time' => '06:00 PM', 'package_id' => $request['package'], 'number' => 7 ],
        ];
        BookingTimesPackage::where('package_id', $request['package'])->delete();

        foreach ($data as $element) {
            BookingTimesPackage::create([
                'day' => $element['day'],
                'opening_time' => $element['opening_time'],
                'closing_time' => $element['closing_time'],
                'package_id' => $element['package_id'],
                'number' => $element['number'],
            ]);
        }

        return response()->json([ 'status' => true ]);
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
        $input = $request->all();
        BookingTimesPackage::findOrFail($id)->update($input);

        //set session message and redirect back booking-times.index
        Session::flash('booking_time_updated', __('backend.booking_time_package_updated'));
        return redirect('/booking-times-package?category='.$input['selectedCategory'].'&package='.$input['selectedPackage']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
