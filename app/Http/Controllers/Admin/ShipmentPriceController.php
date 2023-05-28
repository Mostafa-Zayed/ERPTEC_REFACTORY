<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Shipment;
use App\Models\ShippingType;
use App\Models\ShipmentPrice;
use App\Models\ShipmentZone;
use App\Models\Zone;
use App\Models\ShipmentPriceArabian;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Utils\ModuleUtil;
use Validator;

class ShipmentPriceController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil)
    {
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
         $business_id = request()->session()->get('user.business_id');

         $brands = ShipmentPrice::where('business_id',$business_id)->get();

  
    
        return view('admin.shipmentprice.index',compact('brands'));
    }
 public function show()
    {
        
  }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = $request->session()->get('user.business_id');
       
        $zones = Zone::forDropdown($business_id, false);
      //  $shipments = Shipment::forDropdown($business_id, false);
        $shipments=Shipment::where('business_id',$business_id)->orwhere('business_id',null)->pluck('name','id');
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
    
        return view('admin.shipmentprice.create')
                ->with(compact('quick_add','zones','shipments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['value', 'extra','shipment_id','to','business_id','shipping_cost']);
            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] =$business_id ;

            $brand = ShipmentPrice::create($input);
            
            $output = ['success' => true,
                            'data' => $brand,
                            'msg' => __("brand.added_success")
                        ];
                  
               
                        
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

        return $output;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            
            
        
        
            $business_id = request()->session()->get('user.business_id');
          
              $zones = Zone::forDropdown($business_id, false);
        $shipments = Shipment::forDropdown($business_id, false);
            $brand = ShipmentPrice::where('business_id',$business_id)->find($id);

            return view('admin.shipmentprice.edit')
                ->with(compact('brand','zones','shipments'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['value', 'extra','to','shipment_id','shipping_cost']);
                $business_id = $request->session()->get('user.business_id');

                $brand = ShipmentPrice::where('business_id',$business_id)->findOrFail($id);
                $brand->value = $input['value'];
                $brand->extra = $input['extra'];
                $brand->to = $input['to'];
                $brand->shipping_cost = $input['shipping_cost'];
                $brand->shipment_id = $input['shipment_id'];
             
       
                $brand->update();
             
                $output = ['success' => true,
                            'msg' => __("brand.updated_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }*/


            try {
                $business_id = request()->user()->business_id;

                $brand = ShipmentPrice::where('business_id',$business_id)->findOrFail($id);
             
                $brand->delete();

               

                $output = ['success' => true,
                            'msg' => __("brand.deleted_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return redirect()->back();
        
    }

    public function getBrandsApi()
    {
        try {
            $api_token = request()->header('API-TOKEN');

            $api_settings = $this->moduleUtil->getApiSettings($api_token);
            
            $brands = Country::where('business_id', $api_settings->business_id)
                                ->get();
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        
            return $this->respondWentWrong($e);
        }

        return $this->respond($brands);
    }
}
