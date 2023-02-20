<?php

namespace App\Exports;

use App\Models\products as model;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Http\Controllers\Controller; 
class products implements FromView  
{
   
    public function view(): View
    {
        return view('dashboard.layouts.excel', [
            'records' => model::all()
        ]);
    }
}
