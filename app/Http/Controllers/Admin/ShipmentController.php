<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Country;
use App\User;
use App\Models\City;
use App\Models\Zone;
use App\Models\Shipment;
use App\Arabian\ShipmentArabian;
use App\Models\ShipmentSetting;
use App\Models\Piece;
use App\Models\Product;
use App\Models\Propiece;
use App\Models\Free;
use App\Models\Profree;

use Illuminate\Http\Request;
use App\Utils\TransactionUtil;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Utils\ModuleUtil;
use Validator;
use App\BusinessLocation;

class ShipmentController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $moduleUtil;
    protected $transactionUtil;
    private $jtexpressSettings = [
        'apiAccount' => '',
        'privateKey' => '',
        'customerCode' => '',
        'password' => '',
        'name' => '',
        'mobile' => '',
        'phone' => '',
        'countryCode' => '',
        'prov' => '',
        'city' => '',
        'street' => '',
        'mailBox' => ''
        ];
    /**
     * Constructor
     *
     * @param ProductUtils $product
     * @return void
     */
    public function __construct(ModuleUtil $moduleUtil,TransactionUtil $transactionUtil)
    {
        $this->moduleUtil = $moduleUtil;
         $this->transactionUtil = $transactionUtil;
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

        // dd($business_id);
         $brands = Shipment::where('business_id',$business_id)->orwhere('business_id',null)->orderBy('type','asc')->get();

  
        // dd($brands);
        return view('admin.shipment.index',compact('brands'));
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
           $carriers = User::forDropdown($business_id, true, false, false, true);
        
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
        
        
        $companys=$this->transactionUtil->shipping_company();
        $arabiccompany=$this->transactionUtil->shipping_arcompany();
    
        return view('admin.shipment.create')
                ->with(compact('quick_add','companys','arabiccompany','carriers'));
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
            $input = $request->only(['name', 'name_ar','desc','desc_ar','phone','shipping_tax','type','business_id','user_id']);
            $business_id = $request->session()->get('user.business_id');
          if ($request->hasFile('photo')) {
              $dest = 'assets/images/shipments/';
              $name = str_random(6) . '_' .  $request->photo->getClientOriginalName();
              $request->photo->move($dest, $name);
              
                $input['photo'] = $name;
          }

           $brand = Shipment::create($input);
           $input['rand'] = $brand->id;
            
              /* $type = ShipmentArabian::create($input);*/
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

       // return $output;
           return redirect('shipment')->with('status', $output);
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
        if (!auth()->user()->can('shipment_zones')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            
            
        
        
            $business_id = request()->session()->get('user.business_id');
              $carriers = User::forDropdown($business_id, true, false, false, true);
           
            $brand = Shipment::where('business_id',$business_id)->find($id);

            return view('admin.shipment.edit')
                ->with(compact('brand','carriers'));
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
                $input = $request->only(['name', 'name_ar','desc','desc_ar','phone','user_id']);
                $business_id = $request->session()->get('user.business_id');

                $brand = Shipment::where('business_id',$business_id)->findOrFail($id);
                $brand->name = $input['name'];
                $brand->name_ar = $input['name_ar'];
                $brand->desc = $input['desc'];
                $brand->desc_ar = $input['desc_ar'];
                $brand->phone = $input['phone'];
                $brand->user_id = $input['user_id'];
             
               
              
               
                $brand->save();
             
               
                $type = ShipmentArabian::where('rand',$id)->first();
                if($type){
                 $type->name = $input['name'];
                $type->name_ar = $input['name_ar'];
                $type->desc = $input['desc'];
                $type->desc_ar = $input['desc_ar'];
                $type->phone = $input['phone'];

        
                $type->save();
                }
             
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
       

       
            try {
                $business_id = request()->user()->business_id;

                $brand = Shipment::where('business_id',$business_id)->findOrFail($id);
               
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

                return $output;
               // return redirect()->back();
        
    }

    public function getBrandsApi()
    {
        try {
            $api_token = request()->header('API-TOKEN');

            $api_settings = $this->moduleUtil->getApiSettings($api_token);
            
            $brands = Country::where('business_id', $api_settings->business_id)->get();
            
        } catch (\Exception $e) {
            
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        
            return $this->respondWentWrong($e);
        }

        return $this->respond($brands);
    }
    
    public function setting($id)
    {
        
        if (!auth()->user()->can('sell.edit')) {
            abort(403, 'Unauthorized action.');
        }
        
        $quick_add = false;
        
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
        
        $business_id = request()->session()->get('user.business_id');
        
        $se = ShipmentSetting::where('business_id',$business_id)->first();
         
         if(empty($se))
         {
             $insertt= new ShipmentSetting;
             $insertt->business_id=$business_id;
             $insertt->save();
         }
   
         $siting = ShipmentSetting::where('business_id',$business_id)->first();
         $sshipment = Shipment::find($id);
         
        // dd($sshipment);
         switch($sshipment->name) {
             
            case 'Fedex/Ex': 
                $siting = ShipmentSetting::where('business_id',$business_id)->select('fedex_express_settings','id')->first();
                $fedex_settings = $siting->fedex_express_settings;
                $fedex_settings = (array) json_decode($fedex_settings, true);
                return view('shipments.fedex_express.settings',compact('fedex_settings','siting','quick_add','sshipment'));
                
            case 'Mylerz/Api':
                $business_locations = BusinessLocation::where('business_id','=',$business_id)->select('id','name','location_id')->get();
                return view('shipments.mylerz.settings',compact('siting','quick_add','sshipment','business_locations'));
            
            case 'J&TExpress':
                $siting = ShipmentSetting::where('business_id',$business_id)->select('jtexpress_settings','id')->first();
                $jtexpress_settings = ! empty($siting->jtexpress_settings) ? $this->preaparJTExpressSettings( (array) json_decode($siting->jtexpress_settings)) : $this->jtexpressSettings;
                // dd($jtexpress_settings);
                return view('shipments.jtexpress.settings',compact('siting','quick_add','sshipment','jtexpress_settings'));
        }
        return view('admin.shipment.setting')->with(compact('siting','quick_add','sshipment'));
        
    }
    
    
      public function updateshipmentsetting(Request $request,$id)
      {
        // return $request->all();
        if (!auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            ($request->has('bosta_allow_open')) ? $request['bosta_allow_open'] = true : $request['bosta_allow_open'] = false;
            $input = $request->except(['_token','url']);
            if (! empty($request->input('xturbo_pickupAddress')) || ! empty($request->input('xturbo_fragile')) || ! empty($request->input('xturbo_pickupCity')) || ! empty($request->input('view_fragile')) || ! empty($request->input('view_product_details'))){
                $input['xturbo_settings'] = $this->preaparXturboSettingData($request,$input);
            }
            $settingss = ShipmentSetting::find($id)->update($input);
             
            $output = ['success' => true,
                            'msg' => __("settings.updated_success"),
                            'url' => url('shipment')
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong"),
                            'url' => url('shipment')
                        ];
            }

            return response()->json($output);
        
    }
    
    
      public function editimg($id)
    {
        if (!auth()->user()->can('sell.edit')) {
            abort(403, 'Unauthorized action.');
        }
        
        
      

            return view('admin.shipment.editimg')
                ->with(compact('id'));
             
         
       
       
    }
    
    
    
      public function updateimage(Request $request, $id)
    {
        
        
       
        if (!auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }

    
            try {
                $input = $request->only(['photo']);
                $business_id = $request->session()->get('user.business_id');

                $brand = Shipment::findOrFail($id);
             

                
                  if ($request->hasFile('photo')) {
             
          
          
                  if (file_exists(public_path().'/assets/images/shipments/'.$input['photo'])) {
                        unlink(public_path().'/assets/images/shipments/'.$input['photo']);
                    }
                    
                    
            
                        $dest = 'assets/images/shipments/';
                        $name = str_random(6) . '_' .  $request->photo->getClientOriginalName();
                        $request->photo->move($dest, $name);
                        
                       $brand->photo = $name;

            
          }
        
                
                
                
                
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

       ///  return $output;
            $output =  __("brand.updated_success");
            return back()->with('success',$output);
        
    }
    
    /*
    * Mostafa Zayed 23 / Feb / 2022
    * handel xturbo shipment data from request if exists
    */
    private function preaparXturboSettingData(&$request)
    {
        return json_encode([
            'pickupAddress' => $request->input('xturbo_pickupAddress'),
            'fragile' => $request->input('xturbo_fragile'),
            'pickupCity' => $request->input('xturbo_pickupCity'),
            'view_product_details' => $request->input('view_product_details'),
            'view_fragile' => $request->input('view_fragile')
            ]);
        
    }
    
    private function preaparJTExpressSettings($jtexpress)
    {
        // dd($jtexpress);
        return [
            'apiAccount' => ! empty($jtexpress['apiAccount']) ? $jtexpress['apiAccount'] : null,
            'privateKey' => ! empty($jtexpress['privateKey']) ? $jtexpress['privateKey'] : null,
            'customerCode' => ! empty($jtexpress['customerCode']) ? $jtexpress['customerCode'] : null,
            'password' => ! empty($jtexpress['password']) ? $jtexpress['password'] : null,
            'name' => ! empty($jtexpress['name']) ? $jtexpress['name'] : null,
            'mobile' => ! empty($jtexpress['mobile']) ? $jtexpress['mobile'] : null,
            'phone' => ! empty($jtexpress['phone']) ? $jtexpress['phone'] : null,
            'countryCode' => ! empty($jtexpress['countryCode']) ? $jtexpress['countryCode'] : null,
            'prov' => ! empty($jtexpress['prov']) ? $jtexpress['prov'] : null,
            'city' => ! empty($jtexpress['city']) ? $jtexpress['city'] : null,
            'street' => ! empty($jtexpress['street']) ? $jtexpress['street']: null,
            'mailBox' => ! empty($jtexpress['mailBox']) ? $jtexpress['mailBox']: null,
        ];
    }
    
}

