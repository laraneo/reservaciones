<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerProfileUpdate;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerProfileController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Customer Profile Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing profile views to
    | customer and ability to update profile.
    |
    */


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('customer.profile.index', compact('user'));
    }



    public function update(CustomerProfileUpdate $request, $id)
    {
        $input = $request->all();

        //check if Auth user is making request
        if(Auth::user()->id == $id)
        {
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

            //set session message and redirect back customer.profile.index

            Session::flash('profile_updated', __('backend.profile_updated'));
            return redirect()->route('customerProfile');
        }
        else
        {
            //show 404 page
            return view('errors.404');
        }
    }
}
