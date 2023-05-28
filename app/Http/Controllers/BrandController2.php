<?php

namespace App\Http\Controllers;

use App\Brands;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Interfaces\BrandInterface;
use App\Http\Traits\HasPermissions;

class BrandController2 extends Controller
{
    use HasPermissions;
     /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    protected $brandInterface;
    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil, BrandInterface $brandInterface)
    {
        $this->moduleUtil = $moduleUtil;
        $this->brandInterface = $brandInterface;
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        
        if($this->businessCan(['brand.view','brand.create'])){
            if(request()->ajax()){
                return 'ok';
            }
            return view('brand2.index');
        }
    }
}