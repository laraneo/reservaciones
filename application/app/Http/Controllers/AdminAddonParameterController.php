<?php

namespace App\Http\Controllers;

use App\Addon;
use App\Court;
use App\Category;
use App\Package;
use App\AddonsParameter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminAddonParameterController extends Controller
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
        $addonsParameters = [];
        $packages = [];
        $courts = [];
        if($category && $category !== '') {
            $packages = Package::where('category_id',$category)->get();
            if($queryPackage && $queryPackage !== '') {
                $addonsParameters = AddonsParameter::where('package_id', $queryPackage)->get();
                $courts = Court::where('package_id', $queryPackage)->get();
            }
        }
        $categories = Category::all();
        $selectedCategory = $category && $category !== '' ? $category : '';
        $selectedPackage = $queryPackage && $queryPackage !== '' ? $queryPackage : '';
        return view('addon_parameter.index', compact('addonsParameters','categories','packages','selectedCategory','selectedPackage','courts'));
    }

                /**
     * Generate Days.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function generateAddonParameters(Request $request)
    {
        AddonsParameter::where('package_id', $request['package'])->delete();
        $addons = Addon::where('category_id', $request['category'])->get();
        foreach ($addons as $element) {
            AddonsParameter::create([
                'addon_id' => $element->id,
                'package_id' => $request['package'],
                'booking_min' => 1,
                'booking_max' => 1,
                'player_min' => 1,
                'player_max' => 1,
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
        AddonsParameter::findOrFail($id)->update($input);

        //set session message and redirect back booking-times.index
        Session::flash('addons_parameter_updated', __('backend.addons_parameter_updated'));
        return redirect('/addons-parameters?category='.$input['selectedCategory'].'&package='.$input['selectedPackage']);
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
