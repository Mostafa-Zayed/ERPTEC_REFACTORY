<?php

namespace Modules\Shipment\Http\Controllers;

use App\Http\Controllers\Controller;
use \DB;
use Modules\Shipment\Entities\Company as ShipmentCompany;
use Illuminate\Http\Request;
use App\Address;
use Modules\Shipment\Entities\CityZone;
use Modules\Shipment\Entities\ShipmentPrice;
use Modules\Shipment\Companies\Types\AramexCompany;

class ShipmentController extends Controller
{
    public function index()
    {
         return view('shipment::dashboard');
    }
    
    
    public function shipmentOrder($id = null)
    {
        // dd($id);
        // get order
        // get account
        // get company
        $aramexCompany = new AramexCompany();
        
        $aramexCompany->sendOrder($id);
        
        
    }
    
    public function companyAccounts($id)
    {
        $company = ShipmentCompany::select('id','name')->find($id);
        if($company){
            $business_id = request()->session()->get('user.business_id');
            
            $accounts = DB::table('shipment_accounts')->select('id','name')->where('business_id','=',$business_id)->where('shipment_company_id','=',$id)->pluck('name','id');
            $data = view('shipment::accounts.partials.show_accounts',compact('accounts'))->render();
            // return $data;
            return response()->json([
                'data' => $data,
                'success' => true,
                'message' => 'ok'
            ]);
        }
        
        return [
            'success' => false,
            'message' => "NO Company Found with Id: $id",
            'data' => []
        ];
    }
    
    public function getShipmentCharge(Request $request)
    {
        // return $request->all();
        try {    
         
            $business_id = $request->session()->get('user.business_id');
            $address = Address::with(['state','city','state'])->where('business_id', $business_id)->where('id', $request->address_id)->first(); 
            // return $address;
            $cityZone = CityZone::where('business_id','=',$business_id)->where('state_id','=',$address->state->id)->first();
            // return $cityZone;
            if(! empty($cityZone)){
                // return 'ok';
                // return $request->id;
                // return $cityZone->zone_id;
                $price = ShipmentPrice::where('business_id',$business_id)->where('shipment_company_id','=',$request->id)->where('zone_id','=',$cityZone->zone_id)->first();
                
                if(!empty($price)){
                    $output = ['success' => 1,
                            'value' => !empty($price->value) ? $price->value  : 0,
                        ];
                }else{
                    $output = ['success' => 0,
                            'value' => 0
                        ];
                }
            }else {
                $output = ['success' => 0,
                            'value' => 0
                        ];
            }
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'value' => 0
                        ];
        }
        return $output;
    }
    
    
    // public function shipmentOrder($compnay,$id)
    // {
        
    // }
    
    // public function shipmentOrder($id)
    // {
    //     dd($id);
    // }
}