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
use App\Brands;
use Modules\Shop\Services\ShopService;

class BrandController extends Controller
{
    private $shopService;
    
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }
    
    public function syncNewBrands()
    {
        $businessId = request()->session()->get('business.id');
        
        $brands = Brands::with(['shopBrand'])->where('business_id','=',$businessId)->get();
        
        foreach($brands as $brand){
            
            $itemData = self::prepareBrandsData($brand);
            
            $response = $this->shopService->syncNewBrands(['data' => json_encode($itemData)]);
            
            $result = json_decode($response);
            
            if(! empty($result->id)){
                $brand->shopBrand->update(['uuid' => $result->id]);
                
            }
        }
        
        
        
    }
    
    
    private static function prepareBrandsData(&$brand)
    {
        return [
            'name' => $brand->name,
            'meta_title' => $brand->shopBrand->meta_title ?? null,
            'meta_description' => $brand->shopBrand->meta_description ?? null,
            'logo' => $brand->logo_url,
            'slug' => $brand->slug,
            'id' => $brand->id
        ];
    }
}