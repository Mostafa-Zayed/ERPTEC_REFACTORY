<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Shipment\Services\VooService;
use Illuminate\Http\Request;

class VooCompanyController extends Controller
{
    private $vooService;
    
    public function __construct(VooService $vooService)
    {
        $this->vooService = $vooService;
    }
    
    
    public function index()
    {
        // $data = $this->vooService->getAreas();
        
        return view('shipment::companies.voo.index');
        dd($data);

    }
    
    public function getAreas()
    {
        $data = $this->vooService->getAreas();
        $areas = ! empty($data) ? $data : [];

        $html = view('shipment::companies.voo.render_areas',['areas' => $areas['data']['areas']])->render();
        return response()->json(['options'=>$html]);
    }
    
    public function getCourier()
    {
        $html = view('shipment::companies.voo.render_courier')->render();
        return response()->json(['options'=>$html]);
    }
}