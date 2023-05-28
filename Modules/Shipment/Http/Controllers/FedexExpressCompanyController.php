<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Shipment\Services\FedexExpressService;

class FedexExpressCompanyController extends Controller
{
    
    public function index()
    {
        $service = new FedexExpressService();
        dd($service::$BASE_URL);
        return 'index';
    }
}