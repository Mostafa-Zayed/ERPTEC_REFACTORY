<?php

namespace App\Interfaces\Shipment;

use Illuminate\Http\Request;

interface MylerzShipmentInterface
{
    public function index();
    
    public function updateSettings(Request $request);
}