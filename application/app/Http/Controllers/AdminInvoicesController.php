<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;

class AdminInvoicesController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Admin Addons Controller
    |--------------------------------------------------------------------------
    | This controller is responsible for providing invoices views to admin, to
    | show all invoices, provide ability to edit and delete specific invoice.
    |
    */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        if(config('settings.enable_gst'))
        {
            $gst_amount = round(( config('settings.gst_percentage') / 100 ) * $invoice->amount, 2);
        }
        else
        {
            $gst_amount = 0;
        }

        return view('invoices.view', compact('invoice','gst_amount'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = Invoice::find($id);
        $invoice->update([
            'is_paid' => 1
        ]);

        return redirect()->route('unpaidInvoices');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
