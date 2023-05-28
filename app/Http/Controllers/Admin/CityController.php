<?php

namespace App\Http\Controllers\Admin;

use Datatables;
use Carbon\Carbon;
use App\Models\Country;
use App\Models\City;
use App\Models\State;
use App\Models\Zone;
use App\Models\Feature;
use App\Models\Piece;
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

class CityController extends Controller
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
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }
         $business_id = request()->session()->get('user.business_id');

         $brands = City::with('country')->get();

  
    
        return view('admin.city.index',compact('brands'));
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
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }
        $business_id = $request->session()->get('user.business_id');
       
        
        $quick_add = false;
        if (!empty(request()->input('quick_add'))) {
            $quick_add = true;
        }
     $trafic = Country::forDropdown($business_id, false);
        return view('admin.city.create')
                ->with(compact('quick_add','trafic'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'name_ar','country_id']);
            $business_id = $request->session()->get('user.business_id');
   

            $brand = City::create($input);
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
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            
            
        
        
            $business_id = request()->session()->get('user.business_id');
            $trafic = Country::forDropdown($business_id, false);
           
            $brand = City::find($id);

            return view('admin.city.edit')
                ->with(compact('brand','trafic'));
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
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'name_ar','country_id']);
                $business_id = $request->session()->get('user.business_id');

                $brand = City::findOrFail($id);
                $brand->name = $input['name'];
                $brand->name_ar = $input['name_ar'];
                $brand->country_id = $input['country_id'];
               
              
               
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
        if (!auth()->user()->can('superadmin')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->user()->business_id;

                $brand = City::findOrFail($id);
             
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
        }
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
    public function city(Request $request)
    {
            $ship  = $request->id;
            
            $address = City::where('country_id',$ship)->get();
            $dataa = view('city',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }
    public function cityname(Request $request)
    {
            $ship  = $request->id;
            $c = Country::where('country_name',$ship)->first();
            $address = City::where('country_id',$c->id)->get();
            $dataa = view('city',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }   
    
    public function citynamee(Request $request)
    {
            $ship  = $request->id;
            $c = Country::where('country_name',$ship)->first();
            $address = City::where('country_id',$c->id)->get();
            $dataa = view('city',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }
    
    
    public function statename(Request $request)
    {
            $ship  = $request->id;
            $c = City::where('name',$ship)->first();
            $address = State::where('city_id',$c->id)->get();
            $dataa = view('states',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }
    
    public function statenamee(Request $request)
    {
            $ship  = $request->id;
            $c = City::where('name',$ship)->first();
            $address = State::where('city_id',$c->id)->get();
            $dataa = view('states',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }
    public function cityy(Request $request)
    {
            $ship  = $request->id;
            
            $address = City::where('country_id',$ship)->get();
            $dataa = view('cityy',compact('ship','address'))->render();
              
              return response()->json(['options'=>$dataa]);
    }
}
