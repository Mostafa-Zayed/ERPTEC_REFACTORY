<?php

namespace App\Http\Controllers;

use App\Brands;
use App\Utils\ModuleUtil;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Interfaces\BrandInterface;
use App\Http\Traits\HasPermissions;
use App\Http\Requests\Brands\BrandRequest;
use App\Http\Traits\BusinessService;
use App\Http\Traits\Util;
use Modules\Shop\Entities\ShopBrand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    use BusinessService,Util;
    
    private $quickAdd = false;
    
    protected $brandInterface;
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
        
        if(BusinessService::businessCan(['brand.view','brand.create'])){
            if(request()->ajax()){
                return Datatables::of($this->brandInterface->getAll(request()->session()->get('user.business_id')))
                ->addColumn(
                    'action',
                    '@can("brand.update")
                    <button data-href="{{action(\'BrandController@edit\', [$id])}}" class="btn btn-xs btn-primary edit_brand_button"><i class="glyphicon glyphicon-edit"></i> @lang("messages.edit")</button>
                        &nbsp;
                    @endcan
                    @can("brand.delete")
                        <button data-href="{{action(\'BrandController@destroy\', [$id])}}" class="btn btn-xs btn-danger delete_brand_button"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>
                    @endcan'
                )
                ->removeColumn('id')
                ->rawColumns([2])
                ->make(false);
                
            }
            return view('brand.index');
        }
        
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(BusinessService::businessCan(['brand.create'])){
            if(request()->filled('quick_add')){
                $this->quickAdd = true;
            }
            $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');
            return view('brand.create')->with(['quick_add' => $this->quickAdd, 'is_repair_installed' => $is_repair_installed]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StoreBrand $request)
    // {
        
    //     if(BusinessService::businessCan(['brand.create'])){
            
    //         try{
    //             if($data = $this->brandInterface->add($request->validated())){
    //                 return [
    //                     'success' => true,
    //                     'data' => $data,
    //                     'msg' => __("brand.added_success")
    //                 ];
    //             }
    //         } catch(\Exception $e) {
    //             \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:Brands-" . __FUNCTION__ .$e->getMessage());
    //             return [
    //                 'success' => false,
    //                 'msg' => __("messages.something_went_wrong")
    //             ];
    //     }
    //     }
        
    // }
    public function store(BrandRequest $request)
    {

        if (!auth()->user()->can('brand.create')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->only(['name', 'name_ar','description']);
            $business_id = $request->session()->get('user.business_id');
            $input['business_id'] = $business_id;
            $input['created_by'] = $request->session()->get('user.id');

            if ($this->moduleUtil->isModuleInstalled('Repair')) {
                $input['use_for_repair'] = !empty($request->input('use_for_repair')) ? 1 : 0;
            }
            
            if($request->hasFile('logo')){
                $file = $request->file('logo');
                $path = $file->store('brands',['disk' => 'local']);
                $input['logo'] = $path;
            }
            $input['slug'] = Str::slug($request->name);
            
            $brand = Brands::create($input);
            
            if(! empty($request->meta_title) || $request->meta_description){
                ShopBrand::create([
                    'business_id' => $business_id,
                    'brand_id' => $brand->id,
                    'meta_title' => $request->meta_title,
                    'meta_description' => $request->meta_description
                ]);
            }
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(BusinessService::businessCan(['brand.update'])){
            if (request()->ajax()) {
                $brand = Brands::where('business_id', Util::getBusinessId())->find($id);

                $is_repair_installed = $this->moduleUtil->isModuleInstalled('Repair');

                return view('brand.edit',
                    [
                        'brand' => $brand,
                        'is_repair_installed' => $is_repair_installed
                    ]);
            }
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
        if (!auth()->user()->can('brand.update')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $input = $request->only(['name', 'description']);
                $business_id = $request->session()->get('user.business_id');

                $brand = Brands::where('business_id', $business_id)->findOrFail($id);
                $brand->name = $input['name'];
                $brand->description = $input['description'];

                if ($this->moduleUtil->isModuleInstalled('Repair')) {
                    $brand->use_for_repair = !empty($request->input('use_for_repair')) ? 1 : 0;
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
        if(BusinessService::businessCan(['brand.delete'])){
            if (request()->ajax()) {
                try {

                    $brand = Brands::where('business_id', Util::getBusinessId())->findOrFail($id);
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
        
    }

    public function getBrandsApi()
    {
        try {
            $api_token = request()->header('API-TOKEN');

            $api_settings = $this->moduleUtil->getApiSettings($api_token);
            
            $brands = Brands::where('business_id', $api_settings->business_id)
                                ->get();
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        
            return $this->respondWentWrong($e);
        }

        return $this->respond($brands);
    }
}
