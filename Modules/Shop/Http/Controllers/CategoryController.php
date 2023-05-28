<?php

namespace Modules\Shop\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Menu;
use App\VariationTemplate;
use DB;
use App\Category;
use Modules\Shop\Services\ShopService;
use Modules\Shop\Entities\ShopCategory;

class CategoryController extends Controller
{
    private $shopService;
    
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }
    
    public function syncNewCategories()
    {
        
        $businessId = request()->session()->get('business.id');
        
        // $categories = Category::doesntHave('shopCategory')->where('business_id','=',$businessId)->get();
        
        // $categories = Category::with(['shopCategory'])->where('business_id','=',$businessId)->get();
        
        $categories = Category::with(['sub_categories','shopCategory'])->where('business_id','=',$businessId)->where('parent_id','=',0)->get();
        
        $syncedData = [];
        // dd($categories);
        foreach($categories as $key => $category) {
            $itemData = $this->prepareCategoryData($category);
            $response = $this->shopService->syncNewCategories(['data' => json_encode($itemData)]);
            $response = json_decode($response,true);
            // dd($response);
            foreach($response as $key => $item){
                DB::table('shop_categories')->where('category_id','=',$key)->update(['uuid' => $item]);
            }
        }
        
        
        
        
        
    }
    
    private function prepareCategoryData(&$category)
    {
        $childerns = [];
        
        // check if has child 
        if(isset($category->sub_categories)){
            foreach($category->sub_categories as $sub){
                $childerns[] = $this->prepareCategoryData($sub);
            }
        }
        return [
            'id' => $category->id,
            'name' => $category->name,
            'order_level' => $category->shopCategory->order_level ?? null,
            'banner' => $category->banner_url ?? null,
            'icon' => $category->icon_url ?? null,
            'slug' => $category->slug ?? null,
            'meta_title' => $category->shopCategory->meta_title ?? null,
            'meta_description' => $category->shopCategory->meta_description ?? null,
            'childerns' => $childerns,
            'translations' => [
                [
                    'lang' => 'en',
                    'name' => $category->name
                ],
                [
                    'lang' => $category->name_ar ? 'ar' : null ,
                    'name' => $category->name_ar
                ]
            ]    
        ];
    }
}