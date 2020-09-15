<?php

namespace App\Http\Controllers;

use App\Guest;
use App\Http\Requests\GuestsRequest;
use App\Http\Requests\GuestsUpdateRequest;
use Illuminate\Support\Facades\Session;

class AdminGuestsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Guests Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing guests views
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
        $guests = Guest::all();
        return view('guests.index', compact('guests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('guests.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GuestsRequest $request)
    {
        $input = $request->all();

        Guest::create($input);

        //set session message
        Session::flash('guest_created', __('backend.guest_created'));

        //redirect back to guests.index
        return redirect('/guests');
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
		$guests = Guest::find($id);  //findOrFail($id);
		return view('guests.view', compact('guests'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guest = Guest::findOrFail($id);
        return view('guests.edit', compact('guest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GuestsUpdateRequest $request, $id)
    {
        $input = $request->all();

        //update data into guests table
        Guest::findOrFail($id)->update($input);

        //set session message and redirect back guests.index
        Session::flash('guest_updated', __('backend.guest_updated'));
        return redirect('/guests');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific guest
        $guest = Guest::findOrFail($id);

        //delete guest
        Guest::destroy($guest->doc_id);

        //set session message and redirect back to guests.index
        Session::flash('guest_deleted', __('backend.guest_deleted'));
        return redirect('/guests');
    }
}
