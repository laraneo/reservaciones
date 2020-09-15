<?php

namespace App\Http\Controllers;

use App\Court;
use App\Draw;
use App\Package;
use App\Http\Requests\CourtRequest;
use App\Http\Requests\EventsUpdateRequest;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

use Carbon\Carbon;

class AdminCourtController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Events Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing events views
    | to admin, to show all views, provide ability to edit and delete
    | specific view.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $courts = Court::with(['package'])->get();
        return view('court.index', compact('courts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $packages = Package::all();
        return view('court.create', compact('packages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CourtRequest $request)
    {
        $input = $request->all();
        Court::create($input);

        //set session message
        Session::flash('court_created', __('backend.court_created'));

        //redirect back to court.index
        return redirect('/court');
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
        $events = Court::find($id);  //findOrFail($id);
		return view('court.view', compact('events'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $court = Court::findOrFail($id);
        $packages = Package::all();
        return view('court.edit', compact('court','packages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CourtRequest $request, $id)
    {
        $input = $request->all();
        Court::findOrFail($id)->update($input);

        //set session message and redirect back court.index
        Session::flash('court_updated', __('backend.court_updated'));
        return redirect('/court');
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
        $event = Court::findOrFail($id);


        //delete event
        Court::destroy($event->id);

        //set session message and redirect back to court.index
        Session::flash('court_deleted', __('backend.court_deleted'));
        return redirect('/court');
    }
}
