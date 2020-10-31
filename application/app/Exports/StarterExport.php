<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StarterExport implements FromView
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        $packages = $this->data;
        $test = 'testssssss';
        return view('reports.excel.starter-report', compact('packages','test'));
    }
}