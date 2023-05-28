<?php

namespace Modules\Shipment\Http\Controllers;

use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;

class TestController extends Controller
{
    public function index()
    {
        dd('test2');
    }
}