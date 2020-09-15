<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerDrawsController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Customer Invoice Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing invoice views to
    | customer.
    |
    */

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $category = $request['category'] ? "AND p.category_id = ".$request['category']." " : '';
        $user = auth()->user()->id;
        $categories = Category::all();
        $draws = \DB::select("SELECT dr.id, dr.draw_id,e.description as evento,   dr.package_id, p.title as package, p.category_id, c.title as categoria, dr.draw_date, dr.draw_time, dr.priority, dr.locator, dr.booking_id, dr.status
        FROM draw_requests dr, packages p, categories c,draws d, events e
        WHERE dr.user_id= {$user}
        and p.id=dr.package_id
        and c.id = p.category_id
        and d.id = dr.draw_id
        and e.id= d.event_id
        {$category}
        order by dr.draw_date DESC, dr.priority ASC");

        return view('customer.draws.index', compact('draws','categories'));
    }
}
