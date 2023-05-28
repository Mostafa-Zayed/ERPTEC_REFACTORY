<?php

namespace Modules\Shipment\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Composer\Semver\Comparator;
use Modules\Shipment\Entities\Account;
use App\System;
use Modules\Shipment\Entities\Account as ShipmentAccount;


class AccountController extends Controller
{
    public function index()
    {
        if(! auth()->user()->can('shipment.show_accounts')){
            abort(403, 'Unauthorized action.');
        }
        
        $business_id = request()->session()->get('user.business_id');
        
        $accounts = Account::where('business_id',$business_id)->get();
        
        return view('shipment::accounts.index');
    }
    
    public function store(Request $request)
    {
        DB::table('shipment_accounts')->insert(self::generateSettings($request));
    }
    
    private static function generateSettings(Request &$request)
    {
        return [
            'name' => $request->name,
            'settings' => json_encode($request->except(['_token','name','shipment_company_id'])),
            'shipment_company_id' => $request->shipment_company_id,
            'business_id' => $request->session()->get('user.business_id')
        ];
    }

}