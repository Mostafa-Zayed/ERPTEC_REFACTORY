<?php

namespace App\Http\Controllers;

use App\Warranty;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Request\Warranties\StoreWarranty;

class WarrantyController2 extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('warranties.create');
    }
    
    public function store()
    {
        
    }
}