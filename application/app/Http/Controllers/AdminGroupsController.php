<?php

namespace App\Http\Controllers;

use App\Group;
use App\Http\Requests\GroupsRequest;
use App\Http\Requests\GroupsUpdateRequest;
use Illuminate\Support\Facades\Session;

class AdminGroupsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Groups Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing groups views to
    | admin, to show all groups, provide ability to edit and delete
    | specific group.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $groups = Group::all();
        //$groups = Group::findOrFail($id);
        // $groups = Group::find("1024-10");
		
        // return view('groups.index');
        return view('groups.index', compact('groups'));
		// return view('groups.index', ['groups' => $groups->toArray()]);
		// return view('groups.index', $groups->toArray() );
		// return response('MENSAJE DE PRUEBA NULO', 404);

		// $groups = Group::all();	//find("1024-10"); //find($id);
		// if (!is_null($groups))
			// // Session::flash('group_viewed', __('backend.group_viewed'));
			// return view('groups.index', ['groups' => $groups->toArray()]);
			// // return view('groups.index');
		// else
			// return response('no encontré un Carajo', 404);
		
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('groups.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(GroupsRequest $request)
    {
        $input = $request->all();

        Group::create($input);

        //set session message
        Session::flash('group_created', __('backend.group_created'));

        //redirect back to groups.index
        return redirect('/groups');
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
		// return view('groups.view', compact('groups'));
		// return response('MENSAJE DE PRUEBA NULO', 404);
		
		$group = Group::find($id);  //findOrFail($id);
		if (!is_null($group))
			return view('groups.view', compact('group'));
			// return view('group.view', ['group' => $group->toArray()]);
		else
			return response('no encontré el grupo indicado', 404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $group = Group::findOrFail($id);
        return view('groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(GroupsUpdateRequest $request, $id)
    {
        $input = $request->all();

        //update data into groups table
        Group::findOrFail($id)->update($input);

        //set session message and redirect back groups.index
        Session::flash('group_updated', __('backend.group_updated'));
        return redirect('/groups');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific group
        $group = Group::findOrFail($id);

        //delete group
        Group::destroy($group->id);

        //set session message and redirect back to groups.index
        Session::flash('group_deleted', __('backend.group_deleted'));
        return redirect('/groups');

    }
}
