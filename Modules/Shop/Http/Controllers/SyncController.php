<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;
use Modules\Shop\Utils\ShopUtil;
use App\VariationTemplate;
use DB;
use App\Utils\ModuleUtil;

class SyncController extends Controller
{
    protected $shopUtil;
    protected $moduleUtil;
    
    public function __construct(ShopUtil $shopUtil,ModuleUtil $moduleUtil)
    {
        $this->shopUtil = $shopUtil;
        $this->moduleUtil = $moduleUtil;
    }
    
    public function variationTemplates()
    {
        $data = [];
        $operation = 'create';
        // $service = $this->shopUtil->connection();
        
                
        $businessId = request()->session()->get('business.id');
        // dd(DB::table('business')->pluck('name'));
        $business = DB::table('business')->select('name as business_name')->get();
        dd($business);
        dd(DB::table('business')->findOrFail(1));
        // DB::statement('truncate table shop_sync_details');
        // dd($data);
        // $ids_test = DB::select('SELECT `data` FROM `shop_sync_details` where `business_id` = ? and `sync_type` = ? and `operation` = ? ',[$businessId,'variation_templates',$operation]);
        // $ids_test = DB::select('SELECT `data` FROM `shop_sync_details` where `business_id` = :business_id and `sync_type` = :sync_type and `operation` = :operation ',['business_id' => $businessId,'sync_type' => 'variation_templates', 'operation' => $operation]);
        
        // DB::insert('insert into shop_sync_details (sync_type,operation,data,business_id,created_by) VALUES (?,?,?,?,?)',['variation_templates','update','88',1,1]);
        // dd('ok');
        
        // $ids = DB::table('shop_sync_details')->where('business_id','=',$businessId)->where('sync_type','=','variation_templates')->select('data')->first();
        // if($ids != null) {
            
        // }
        
        // $query = VariationTemplate::where('business_id','=',$businessId)->select('id','name');
        
        // $ids = $query->pluck('id')->toArray();
        
        // DB::table('shop_sync_details')->where('business_id','=',$businessId)->where('sync_type','=','variation_templates')->insert([
        //     'business_id' => $businessId,
        //     'created_by' => request()->session()->get('user.id'),
        //     'sync_type' => 'variation_templates',
        //     'operation' => 'create',
        //     'data' => json_encode($ids)
        // ]);
        // $variationTemplates = VariationTemplate::where('business_id','=',$businessId)->select('id','name')->get()->toArray();
        
        // $data = ['data' => $variationTemplates];
        
        // $response = $service->publishVariationTemplates($data);
        // dd($response);
        // dd($test);
    }
    
    public function deleteVariationTemplates()
    {
        $service = $this->shopUtil->connection();
        
        $data = ['data' => []];
        
        $response = $service->deleteVariationTemplates($data);
        
        dd($response);
    }
    
    public function updateVariationTemplates()
    {
        
    }
    public function categories()
    {
        $data = [];
        
        $service = $this->shopUtil->connection();
        
        $businessId = request()->session()->get('business.id');
        
        $ids = DB::table('categories')->where('business_id','=',$businessId)->where('sync_type','=','categories')->select('data')->first();
        
        if($ids != null) {
            
        }
        
        $query = DB::table('categories')->where('business_id','=',$businessId)->select('id','name');
        
        $ids = $query->pluck('id')->toArray();
        
        DB::table('shop_sync_details')->where('business_id','=',$businessId)->where('sync_type','=','categories')->insert([
            'business_id' => $businessId,
            'created_by' => request()->session()->get('user.id'),
            'sync_type' => 'categories',
            'operation' => 'create',
            'data' => json_encode($ids)
        ]);
        
        $variationTemplates = DB::table('categories')->where('business_id','=',$businessId)->select('id','name')->get()->toArray();
        
        $data = ['data' => $variationTemplates];
        
        $response = $service->publishVariationTemplates($data);
        dd($response);
    }
    
    public function syncCategories()
    {
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'shop_module') && auth()->user()->can('shop.sync_categories')))) {
            abort(403, 'Unauthorized action.');
        }
        
        $notAllowed = $this->shopUtil->notAllowedInDemo();
        
        if (!empty($notAllowed)) {
            return $notAllowed;
        }
        
        try{
            
            DB::beginTransaction();
            
            $business_id = request()->session()->get('business.id');
            
            $user_id = request()->session()->get('user.id');
            
            $parentsCategories = $this->shopUtil->getCategoriesData($business_id,'categories',$user_id);
            
            $response = $service->syncCategories($data);
            dd($parentsCategories);
        } catch(\Exception $e) {
            dd($e);
        }
    }
    
    
    public function brands()
    {
        
    }
}