<?php

namespace App\Http\Traits;

use App\Business;
use App\Http\Traits\BusinessService;

trait ProductService
{
     /**
     * Generates product sku
     *
     * @param string $string
     *
     * @return generated sku (string)
     */
    public static function generateProductSku($string)
    {
        $business_id = request()->session()->get('user.business_id');
        $sku_prefix = Business::where('id', $business_id)->value('sku_prefix');

        return $sku_prefix . str_pad($string, 4, '0', STR_PAD_LEFT);
    }
    
    public static function generateStorFields(& $moduleFields)
    {
        return array_merge(config('product.store_form_fields'), $moduleFields);
    }
    
    public static function generateStoreData($request,$fields)
    {
        $data = $request->only($fields);
        
        $data['business_id'] = BusinessService::getBusinessId();
        $data['created_by'] = BusinessService::getUser() ;
        $data['enable_stock'] = (!empty($request->input('enable_stock')) &&  $request->input('enable_stock') == 1) ? 1 : 0;
        $data['not_for_selling'] = (!empty($request->input('not_for_selling')) &&  $request->input('not_for_selling') == 1) ? 1 : 0;
        $data['sub_category_id']     = !empty($request->input('sub_category_id')) ? $request->input('sub_category_id') : null;
        $expiry_enabled = BusinessService::getSessionValue('enable_product_expiry','business');
        return $data;     

    
        
        return $data;
        return [];
    }
}