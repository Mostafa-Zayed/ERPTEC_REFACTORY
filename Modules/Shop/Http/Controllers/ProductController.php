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
use App\Product;

class ProductController extends Controller
{
    private $shopService;
    
    public function __construct(ShopService $shopService)
    {
        $this->shopService = $shopService;
    }
    
    public function syncNewProducts()
    {
        $businessId = request()->session()->get('business.id');
        
        $products = Product::with([
            'product_variations:product_id,name,is_dummy',
            'brand:id,name,name_ar',
            'unit:id,actual_name',
            'category:id,name,name_ar',
            'product_tax:id,name,amount',
            'media'
        ])->where('business_id','=',$businessId)->get();
        dd($products,);
        dd('products');
    }
    
    
    private function prepareProductData(&$product)
    {
        return [
            'name' => $product->name,
            'added_by' => 'admin',
            // 'user_id' => 1,,
            'category_id' => 0,
            'brand_id' => null,
            // 'barcode' => null,
            // 'refundable' => 0,
            // 'photos' => number,
            // 'thumbnail_img' => number,
            // 'unit' => string,
            // unit_price' => string,
            // '"button" => "unpublish"',
        //      $product->min_qty = $request->min_qty;
        // $product->low_stock_quantity = $request->low_stock_quantity;
        // $product->stock_visibility_state = $request->stock_visibility_state;
        // $product->external_link = $request->external_link;
        // $product->external_link_btn = $request->external_link_btn;
            
        ];
    }
}