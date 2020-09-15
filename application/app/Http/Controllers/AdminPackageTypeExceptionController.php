<?php

namespace App\Http\Controllers;

use App\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPackageTypeExceptionController extends Controller
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

        $data = [

            [

                'package' => 'Cancha 1',
                'single' => 'Single',
                'days_single' => [

                    'day' => [
                        'title' => 'Lunes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Martes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Miercoles',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Jueves',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Viernes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Sabado',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'DOmingo',
                        'value' => '1:00 PM - 6:00 PM',
                    ],
                ],
                'double' => 'Double',
                'days_double' => [

                    'day' => [
                        'title' => 'Lunes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Martes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Miercoles',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Jueves',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Viernes',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'Sabado',
                        'value' => '1:00 PM - 6:00 PM',
                    ],

                    'day' => [
                        'title' => 'DOmingo',
                        'value' => '1:00 PM - 6:00 PM',
                    ],
                ],
            ],

        ];

        $categories = Category::where('category_type', 1)->get();

        return view('package-type-exception.index', compact('draws','categories'));
    }
}
