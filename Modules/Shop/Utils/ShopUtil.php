<?php
namespace Modules\Shop\Utils;

use App\Business;
use App\Category;
use App\Contact;
use App\Address;
use App\Exceptions\PurchaseSellMismatch;
use App\Product;
use App\TaxRate;
use App\Transaction;
use App\Utils\ProductUtil;
use App\Utils\TransactionUtil;
use App\Utils\Util;
use App\Utils\ContactUtil;
use App\VariationLocationDetails;
use App\VariationTemplate;
use Automattic\WooCommerce\Client;
use DB;
use Modules\Woocommerce\Entities\WoocommerceSyncLog;
use Modules\Woocommerce\Exceptions\WooCommerceError;
use Modules\Shop\Services\ShopService;
use Modules\Shop\Entities\ShopSyncDetails;

class ShopUtil extends Util
{
    private static $resetOperations = 'reset';
    
    public function __construct()    
    {
        
    }
    
    public function getApiSettings()
    {
        $businessId = request()->session()->get('business.id');
        return json_decode(Business::select('api_settings')->find($businessId)['api_settings'],true);
        
    }
    
    public function connection()
    {
        if(! empty($shopSettings = $this->getApiSettings()['shop'])){
            return new ShopService($shopSettings);
        }
        return 'add shop settings first';
      
        
    }
    
    public function getCategoriesData($businessId,$type,$userId)
    {
        $lastSync = $this->getLastSync($businessId,$type,false);
        
        //Update parent categories
        $query = Category::where('business_id', $businessId)->with('shopCategory')->where('category_type', 'product')->where('parent_id', 0);
        
        //Limit query to last sync
        if (!empty($lastSync)) {
            $query->where('updated_at', '>', $lastSync);
        }
        
        $categories = $query->get();
        
        $category_data = [];
        $new_categories = [];
        $created_data = [];
        $updated_data = [];
        
        foreach($categories as $category) {
            if(empty($category->shopCategory)){
                $category_data['create'][]  = [
                    'name' => $category->name,
                    'translations' => [
                        [
                            'lang' => 'en',
                            'name' => $category->name
                        ],
                        [
                            'lang' => 'ar',
                            'name' => $category->name_ar
                        ]
                    ]
                ];
                
                $new_categories[] = $category;
                $created_data[] = $category->name;
            }else {
                $category_data['update'][] = [
                    'id' => $category->shopCategory->uuid,
                    'name' => $category->name
                ];
                $updated_data[] = $category->name;
            }
        }
        
        return [
            'new' => $new_categories,
            'create' => ! empty($category_data['create']) ? $category_data['create'] :  [],
            'update' => ! empty($category_data['update']) ? $category_data['update'] : []
        ];
    }
    
    public function prepareSyncData($businessId,$type,$userId)
    {
        // $lastSync = $this->getLastSync($businessId,$type,false);
        
        // $model = $this->resolveCategoryModel($type);
        
        // //Update parent categories
        // $query = $model::where('business_id', $businessId)->where('parent_id', 0);
        
        // if($type == 'categories') {
        //     $query->where('category_type','product')-;
        // }
        // //Limit query to last sync
        // if (!empty($lastSync)) {
        //     $query->where('updated_at', '>', $lastSync);
        // }
        
        // $categories = $query->get();
        // dd($categories);
    }
    
    public function resolveCategoryModel($type)
    {
        $model = $type == 'categories' ? resolve(Category::class) : null;
        return $model;
    }
    /**
     * Retrives last synced date from the database
     * @param id $business_id
     * @param string $type
     * @param bool $for_humans = true
     */
    private  function getLastSync($businessId, $type = null, $forHumans = true)
    {
        $lastSync = DB::table('shop_sync_details')->where('sync_type','=',$type)->where('business_id','=',$businessId)->max('created_at');
        
        $lastReset = DB::table('shop_sync_details')
                        ->where('sync_type','=',$type)
                        ->where('business_id','=',$businessId)
                        ->where('operation','=',self::$resetOperations)
                        ->max('created_at');
                        
        if(! empty($lastSync) && ! empty($lastReset) && $lastReset >= $lastSync){
            $lastSync = null;
        }
        
        if (!empty($lastSync) && $forHumans) {
            $lastSync = \Carbon::createFromFormat('Y-m-d H:i:s', $lastSync)->diffForHumans();
        }
        return $lastSync;
    }
    
    private function prepareCategoryData(&$category)
    {
        return [
            'name' => $category->name,
            'order_level' => $category->shopCategory->order_level ?? null,
            'banner' => $category->shopCategory->banner ?? null,
            'icon' => $category->shopCategory->icon ?? null,
            'slug' => $category->slug ?? null,
            'meta_title' => $category->shopCategory->meta_title ?? null,
            'meta_description' => $category->shopCategory->meta_description ?? null,
            'translations' => [
                [
                    'lang' => 'en',
                    'name' => $category->name
                ],
                [
                    'lang' => 'ar',
                    'name' => $category->name_ar
                ]
            ]    
        ];
    }
}

