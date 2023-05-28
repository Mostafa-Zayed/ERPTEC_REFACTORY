<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InvoiceLayout;
use App\Repositories\InvoiceLayoutRepository;
use App\Interfaces\InvoiceLayoutInterface;
use App\Interfaces\InvoiceSchemeInterface;
use App\Repositories\BusinessLocationRepository;

class TestController extends Controller
{
    // private $invoiceSchemeInterface;
    // private $invoiceLayoutInterface;
    // private $businessLocationRepository;
    
    // public function __construct(InvoiceLayoutInterface $invoiceLayoutInterface,InvoiceSchemeInterface $invoiceSchemeInterface,BusinessLocationRepository $businessLocationRepository)
    // {
    //     $this->invoiceLayoutInterface = $invoiceLayoutInterface;
    //     $this->invoiceSchemeInterface = $invoiceSchemeInterface;
    //     $this->businessLocationRepository = $businessLocationRepository;
    // }

    // public function test()
    // {
    //     // $business_id = session()->get('user.business_id');
    //     // $location_test = ['name' => 'test' ,'country' => 'egypt'];
    //     // $result = $this->businessLocationRepository->addLocation($business_id,$location_test);
    //     // dd($result);
    //     // $location_test = ['name' => 'test' ,'country' => 'egypt'];
    //     // dd($this->businessLocationRepository->addLocation($business_id,$location_test));
    //     // dd($this->invoiceLayoutInterface->getDefault($business_id,['id','is_default']));
    //     // $business_id = session()->get('user.business_id');
    //     // $data = InvoiceLayout::forbusiness($business_id)->isdefault()->get();
    //     // dd($data);
    //     // dd('ok');
    //     // $business_id = session()->get('user.business_id');
    //     // $data = $this->invoiceLayoutRepository->getDefault($business_id);
    //     // dd($data);
    // }
}