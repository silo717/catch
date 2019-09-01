<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\OrdersExport;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function createCsv() 
    {
        return Excel::store(new OrdersExport(), 'orders.csv');
    }
}
