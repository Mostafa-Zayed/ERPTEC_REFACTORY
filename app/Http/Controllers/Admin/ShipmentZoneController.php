<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ShipmentZone;
use App\Models\Shipment;
use App\Models\Zone;
use App\Models\State;
use App\Models\City;
use App\Models\Country;
use App\Models\CityZone;
use Datatables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Utils\ModuleUtil;
use Validator;

class ShipmentZoneController extends Controller
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

         $brands = Zone::where('business_id',$business_id)->get();

  
    
        return view('admin.zones.index',compact('brands'));
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
        if ( !auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = $request->session()->get('user.business_id');
       
        
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
    
        return view('admin.zones.create')
                ->with(compact('quick_add'));
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
            $input = $request->only(['name', 'name_ar','desc','desc_ar','business_id']);
            $business_id = $request->session()->get('user.business_id');
            

            $brand = Zone::create($input);
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
          
           
            $brand = Zone::where('business_id',$business_id)->find($id);

            return view('admin.zones.edit')
                ->with(compact('brand'));
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
                $input = $request->only(['name', 'name_ar','desc','desc_ar','phone','shipping_tax']);
                $business_id = $request->session()->get('user.business_id');

                $brand = Zone::where('business_id',$business_id)->findOrFail($id);
                $brand->name = $input['name'];
                $brand->name_ar = $input['name_ar'];
                $brand->desc = $input['desc'];
                $brand->desc_ar = $input['desc_ar'];
       
               
                $brand->save();
             
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
       /* if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }*/

      
            try {
                $business_id = request()->user()->business_id;

                $brand = Zone::find($id);
             
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
            
            $brands = Zone::where('business_id', $api_settings->business_id)
                                ->get();
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        
            return $this->respondWentWrong($e);
        }

        return $this->respond($brands);
    }
    
        public function city($id)
    {
        //--- Validation Section
      
        //--- Validation Section Ends
        $city = Zone::find($id);
      
       return view('admin.zones.zones',compact('city'));
    } 
    
     public function citycreate()
    {
        
          $business_id = request()->user()->business_id;
          $country = Country::forDropdown($business_id, true);
        
          $zones = Zone::forDropdown($business_id, false);
       // $zones = Zone::where('business_id',$business_id)->get();
        return view('admin.zones.city',compact('zones','country'));
    }

    //*** POST Request
    public function citystore(Request $request)
    {
        //--- Validation Section
      
        //--- Validation Section Ends
           try {
        $business_id = request()->user()->business_id;
                if($request->state_id) {

                                    $interest_array = $request->input('state_id');
                                   
                                    $array_len = count($interest_array);
                                    for ($i = 0; $i < $array_len; $i++) {
                                        $old = CityZone::where('business_id',$business_id)->where('state_id',$interest_array[$i])->first();
                                    if($old){
                                          $old->zone_id = $request->zone_id ;
                                          $old->update();
                                        
                                    }else{
                                        $city = new CityZone;
                                          $city->business_id = $business_id ;
                                          $city->zone_id = $request->zone_id ;
                                          $city->state_id = $interest_array[$i];
                                          $city->save();
                                    }
                                    }
                        
                                }
       
  
      
       $output = ['success' => true,
                     
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
     public function citydelete($id)
    {
       
            try {
        $business_id = request()->user()->business_id;
        //--- Validation Section Ends
        $city = CityZone::where('business_id',$business_id)->where('state_id',$id)->delete();
      
    
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
         
           public  function  cities(Request $request){
          
           $address =City::where('country_id',$request->id)->get();
            $data = view('cityy',compact('address'))->render();
        
              return response()->json(['options'=>$data]);
       }  
       
       public  function  states(Request $request){
          
           $address =State::where('city_id',$request->id)->get();
            $data = view('state',compact('address'))->render();
        
              return response()->json(['options'=>$data]);
       }   public  function  statess(Request $request){
          
           $address =State::where('city_id',$request->id)->get();
            $data = view('states',compact('address'))->render();
        
              return response()->json(['options'=>$data]);
       }  
    
}
