<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Support\Facades\Auth;

class CustomerInvoiceController extends Controller
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
    public function index()
    {
        $user = Auth::user();
        $invoices = $user->invoices()->get();
        return view('customer.invoices.index', compact('invoices'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);

        if(config('settings.enable_gst'))
        {
            $gst_amount = round((config('settings.gst_percentage') / 100 ) * $invoice->amount, 2);
        }
        else
        {
            $gst_amount = 0;
        }

        return view('customer.invoices.view' , compact('invoice','gst_amount'));
    }
}
