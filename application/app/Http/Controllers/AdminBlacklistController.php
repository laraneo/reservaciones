<?php

namespace App\Http\Controllers;

use App\Blacklist;
use App\Http\Requests\BlacklistRequest;
use App\Http\Requests\BlacklistUpdateRequest;
use Illuminate\Support\Facades\Session;

class AdminBlacklistController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Blacklist Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing blacklists views
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
        $blacklists = Blacklist::all();
        return view('blacklist.index', compact('blacklists'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('blacklist.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BlacklistRequest $request)
    {
        $input = $request->all();

        Blacklist::create($input);

        //set session message
        Session::flash('blacklist_created', __('backend.blacklist_created'));

        //redirect back to blacklists.index
        return redirect('/blacklist');
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
		$blacklists = Blacklist::find($id);  //findOrFail($id);
		return view('blacklist.view', compact('blacklists'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $blacklist = Blacklist::findOrFail($id);
        return view('blacklist.edit', compact('blacklist'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(BlacklistUpdateRequest $request, $id)
    {
        $input = $request->all();

        //update data into blacklists table
        Blacklist::findOrFail($id)->update($input);

        //set session message and redirect back blacklists.index
        Session::flash('blacklist_updated', __('backend.blacklist_updated'));
        return redirect('/blacklist');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific blacklist
        $blacklist = Blacklist::findOrFail($id);

        //delete blacklist
        Blacklist::destroy($blacklist->doc_id);

        //set session message and redirect back to blacklists.index
        Session::flash('blacklist_deleted', __('backend.blacklist_deleted'));
        return redirect('/blacklist');
    }
}
