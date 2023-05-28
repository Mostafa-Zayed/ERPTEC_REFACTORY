<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Composer\Semver\Comparator;
use Modules\Shipment\Entities\Company;

use App\System;

class CompanyController extends Controller
{
    public function index()
    {
        if(! auth()->user()->can('shipment.show_companies')){
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');
        
        $companies = Company::where('business_id',$business_id)->orWhere('business_id',null)->get();
        
        return view('shipment::companies.index',compact('companies'));
    }
    
    public function addAccount($name)
    {
        if (!auth()->user()->can('shipment.add_account')) {
            abort(403, 'Unauthorized action.');
        }
        
        $company = Company::where('name','=',$name)->first();
        
        $business_id = request()->session()->get('user.business_id');
        
        return view('shipment::companies.accounts.' . strtolower($company->name),['company' => $company]);
    }
    
    private function getShipmentCompanySettings(string $companyName)
    {
        $compaines = config('shipments.companies');
        if(array_key_exists($companyName,$compaines)){
            return $compaines[$companyName];
        }
        return [];
    }
}