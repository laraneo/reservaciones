<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsersRequest;
use App\Http\Requests\UsersUpdateRequest;
use App\Role;
use App\User;
use App\Photo;
use Illuminate\Support\Facades\Session;


class AdminUsersController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Users Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing users views to
    | admin, to show all users, provide ability to edit and delete
    | specific user.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersRequest $request)
    {
        $input = $request->all();

        //check if an image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;
        }
        if($input['group_id'] == null) {
            $input['group_id'] = '';
        }
        //encrypt password and persist data into users table
        $input['password'] = bcrypt($request->password);
        User::create($input);

        //set session message
        Session::flash('user_created', __('backend.user_created'));

        //redirect back to users.index
        return redirect('/users');
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
        $user = User::findOrFail($id);
        $roles = Role::all();
        return view('users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, $id)
    {
        $input = $request->all();

        if($input['group_id'] == null) {
            $input['group_id'] = '';
        }

        //check if image is selected
        if($image = $request->file('photo_id'))
        {
            //give a name to image and move it to public directory
            $image_name = time().$image->getClientOriginalName();
            $image->move('images',$image_name);

            //persist data into photos table
            $photo = Photo::create(['file'=>$image_name]);

            //save photo_id to user $input
            $input['photo_id'] = $photo->id;

            //find user
            $user = User::findOrFail($id);

            //unlink old photo if set
            if($user->photo != NULL)
            {
                unlink(public_path().$user->photo->file);
            }

            //delete data from photos table
            Photo::destroy($user->photo_id);
        }

        //update data into users table
        User::findOrFail($id)->update($input);

        //set session message and redirect back users.index
        Session::flash('user_updated', __('backend.user_updated'));
        return redirect('/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //find specific user
        $user = User::findOrFail($id);

        if($user->photo)
        {
            //unlink image
            unlink(public_path().$user->photo->file);

            //delete from photo table
            Photo::destroy($user->photo_id);

        }

        //delete user
        User::destroy($user->id);

        //set session message and redirect back to users.index
        Session::flash('user_deleted', __('backend.user_deleted'));
        return redirect('/users');

    }
}
