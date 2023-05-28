<?php

namespace Modules\Shop\Services;

use App\Traits\ConsumesExternalServices;
use Modules\Shop\Traits\InteractsWithShopResponse;
use Modules\Shop\Traits\AuthorizationShopRequest;

class ShopService
{
    private $base_url = 'https://shop.erptec.net';
    private $apiVersion = 'api/v2/';
    
    use ConsumesExternalServices;
    use InteractsWithShopResponse;
    use AuthorizationShopRequest;
    
    public function __construct()
    {
        $this->base_url = 'https://shop.erptec.net';
    }
    
    private static function getBusinessShop()
    {
        $businessId = request()->session()->get('business.id');
        return json_decode(Business::select('api_settings')->find($businessId)['api_settings'],true);
    }
    public function getLanguages()
    {
        return $this->makeRequest('GET', $this->apiVersion . '/' . 'languages');
    }
    
    public function getSellerOrders()
    {
        return $this->makeRequest('GET','seller/orders');
    }
    
    public function getCities()
    {
        return $this->makeRequest('GET','cities');
    }
    
    public function getStates()
    {
        return $this->makeRequest('GET','states');
    }
    
    public function getStoreDetails($id)
    {
        return $this->makeRequest('GET','shops/details/' . $id);
    }
    
    public function publishVariationTemplates($data)
    {
        return $this->makeRequest('POST','attributes',[],$data,[]);
    }
    
    public function publishCategories($data)
    {
        return $this->makeRequest('POST','categories',[],$data,[]);
    }
    
    // public function publishBrands($data)
    // {
    //     return $this->makeRequest('POST','brands',[],$data,[]);
    // }
    
    public function deleteVariationTemplates($data)
    {
        return $this->makeRequest('DELETE','attributes',[],$data,[]);
    }
    
    public function syncNewCategories($data)
    {
        return $this->makeRequest('POST','categories',[],$data,[]);
    }
    
    public function syncNewBrands($data)
    {
        
        return $this->makeRequest('POST','brands',[],$data,[]);
    }
    
    public function syncNewProduct($product)
    {
        return $this->makeRequest('POST','products',[],$product,[]);
    }
}