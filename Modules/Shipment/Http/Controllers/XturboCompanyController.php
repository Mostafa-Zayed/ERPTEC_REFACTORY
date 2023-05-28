<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Shipment\Services\XturboService;

class XturboCompanyController extends Controller
{
    
    public function index()
    {
        $service = new XturboService();
        dd($service::$BASE_URL);
        return 'index';
    }
}