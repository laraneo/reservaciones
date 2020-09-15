<?php

namespace App\Http\Controllers;

use App\PackagesType;
use App\Draw;
use App\Package;
use App\Category;
use App\Http\Requests\PackagesTypesRequest;
use App\Http\Requests\EventsUpdateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Carbon\Carbon;

class AdminPackagesTypesController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $category = $request['category'];
        $package = $request['package'];
        
        $packages = [];
        $courts = PackagesType::with(['package'])->get();
        if($category && $category !== '') {
            $courts = PackagesType::whereHas('package', function($q) use ($category) {
                $q->where('category_id', $category);
            })->get();
            $packages = Package::where('category_id', $category)->get();
        }
        if($package && $package !== '') {
            $courts = PackagesType::where('package_id', $package)->get();
        }
        $categories = Category::all();
        $selectedCategory = $category && $category !== '' ? $category : '';
        $selectedPackage = $package && $package !== '' ? $package : '';
        return view('packages_types.index', compact('courts', 'categories' ,'selectedCategory','packages','selectedPackage'));
    }

    public function getPackageByCategory(Request $request){
        $packages = Package::where('category_id', $request['category'])->get();
        return  response()->json([ 'data' => $packages ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        $categories = Category::all();
        return view('packages_types.create', compact('packages','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PackagesTypesRequest $request)
    {
        $input = $request->all();
        PackagesType::create($input);

        //set session message
        Session::flash('packages_types_created', __('backend.packages_types_created'));

        //redirect back to packages_types.index
        return redirect('/packages-types');
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
        $events = PackagesType::find($id);  //findOrFail($id);
		return view('packages_types.view', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $court = PackagesType::findOrFail($id);
        $packages = Package::all();
        return view('packages_types.edit', compact('court','packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PackagesTypesRequest $request, $id)
    {
        $input = $request->all();
        PackagesType::findOrFail($id)->update($input);

        //set session message and redirect back packages_types.index
        Session::flash('packages_types_updated', __('backend.packages_types_updated'));
        return redirect('/packages-types');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific event
        $event = PackagesType::findOrFail($id);


        //delete event
        PackagesType::destroy($event->id);

        //set session message and redirect back to packages_types.index
        Session::flash('packages_types_deleted', __('backend.packages_types_deleted'));
        return redirect('/packages-types');
    }
}
