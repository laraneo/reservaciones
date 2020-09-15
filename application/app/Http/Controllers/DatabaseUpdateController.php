<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;

class DatabaseUpdateController extends Controller
{
    public function update()
    {
        Artisan::call('migrate', ['--force' => true]);
        Artisan::call('db:seed' , ['--force' => true]);

        Session::flash('database_updated', __('backend.database_updated'));
        return redirect('home');
    }
}
