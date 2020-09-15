<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserPasswordController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | User Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for password change during login session.
    |
    */


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('password_change.index');
    }


    /**
     * @param UserPasswordRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UserPasswordRequest $request, $id)
    {
        $input = $request->all();
        if(Auth::user()->id == $id)
        {
            $new_password = bcrypt($input['password']);

            $user = Auth::user();

            $user->update([
                'password' => $new_password
            ]);

            Session::flash('password_changed', __('backend.password_changed'));
            return redirect()->route('changePassword');
        }
        else
        {
            Session::flash('password_error',__('backend.password_error'));
            return redirect()->route('changePassword');
        }
    }
}
