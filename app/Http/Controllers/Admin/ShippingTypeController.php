<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\City;
use App\Models\Zone;
use App\Models\ShippingType;
use App\Models\Piece;
use App\Arabian\ShippingTypeArabian;
use App\Models\Product;
use App\Models\Propiece;
use App\Models\Free;
use App\Models\Profree;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use App\Utils\ModuleUtil;
use Validator;

class ShippingTypeController extends Controller
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
        if (!auth()->user()->can('sell.view')) {
            abort(403, 'Unauthorized action.');
        }
         $business_id = request()->session()->get('user.business_id');

         $brands = ShippingType::where('business_id',$business_id)->get();

  
    
        return view('admin.shippingtype.index',compact('brands'));
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
        if (!auth()->user()->can('sell.create')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = $request->session()->get('user.business_id');
       
        
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
    
        return view('admin.shippingtype.create')
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
        if (!auth()->user()->can('sell.store')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'name_ar','desc','desc_ar','phone','shipping_tax','business_id']);
            $business_id = $request->session()->get('user.business_id');
            

            $brand = ShippingType::create($input);
            $input['rand'] = $brand->id;
            
            $type = ShippingTypeArabian::create($input);
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
        if (!auth()->user()->can('sell.edit')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            
            
        
        
            $business_id = request()->session()->get('user.business_id');
          
           
            $brand = ShippingType::where('business_id',$business_id)->find($id);

            return view('admin.shippingtype.edit')
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
        if (!auth()->user()->can('sell.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'name_ar','desc','desc_ar','phone','shipping_tax']);
                $business_id = $request->session()->get('user.business_id');

                $brand = ShippingType::where('business_id',$business_id)->findOrFail($id);
                $brand->name = $input['name'];
                $brand->name_ar = $input['name_ar'];
                $brand->desc = $input['desc'];
                $brand->desc_ar = $input['desc_ar'];
             
               
              
               
                $brand->save();
                
                
                    $type = ShippingTypeArabian::where('rand',$id)->first();
                 $type->name = $input['name'];
                $type->name_ar = $input['name_ar'];
                $type->desc = $input['desc'];
                $type->desc_ar = $input['desc_ar'];
        
        
                $type->save();
                
             
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

                $brand = ShippingType::where('business_id',$business_id)->findOrFail($id);
                  $type = ShippingTypeArabian::where('rand',$id)->delete();
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
