<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountTransaction;
use App\AccountType;
use App\TransactionPayment;
use App\Utils\Util;
use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\Facades\DataTables;
use App\Media;
use App\Address;

class AddressController extends Controller
{
    public function getCustomerAddress(Request $request)
    {
        // return $request->all();
        // $ship  = $request->id;
        $contact_id  = $request->contact;
        // $transaction  = $request->trans;

        $business_id = request()->session()->get('user.business_id');
        
        // $price = ShipmentPrice::where('shipment_id',$ship)->pluck('to');
        
        // $city = CityZone::whereIn('zone_id',$price)->pluck('state_id');
        // $state = State::whereIn('id',$city)->pluck('name');
        
        
        $addresses = DB::table('addresses')->where('business_id',$business_id)->where('contact_id',$contact_id)->get();
        // return $addresses;
     //   dd($address);
        // $business_locations = BusinessLocation::forDropdown($business_id, false);
        // $customers = Contact::customersDropdown($business_id, false);
      
        // $sales_representative = User::forDropdown($business_id, false, false, true);
        
         
            $dataa = view('addresses.partials.render_address',['addresses' => $addresses])->render();
              
              return response()->json(['options'=>$dataa]);
    }
    
    
    public function getShipment(Request $request)
    {
        
        
        $address = Address::with(['state','city','state'])->where('id','=',$request->id)->first();
        
        $business_id = request()->session()->get('user.business_id');
        dd($address);
    }
    
    public function info(Request $request)
    {
        // return $request->all();
        
        $address = Address::with(['state','city','state'])->where('id','=',$request->id)->first();
        $data = view('sale_pos.partials.render_cutomer_address',[
            'address' => $address
        ])->render();
        return response()->json(['options'=>$data]);
    }
}