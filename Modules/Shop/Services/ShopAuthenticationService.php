<?php

namespace Modules\Shop\Services;

use App\Traits\ConsumesExternalServices;
use Modules\Shop\Traits\InteractsWithShopResponse;
use App\Business;

class ShopAuthenticationService
{
    use ConsumesExternalServices;
    use InteractsWithShopResponse;
    
    private $base_url;
    private $userName;
    private $password;
    private $type;
    private $code;
    private $apiVersion;
    
    public function __construct()
    {
        if(! empty($shopSettings = $this->getApiSettings()['shop'])){
            $this->base_url = $shopSettings['url'];
            $this->userName = $shopSettings['username'];
            $this->password = $shopSettings['password'];
            $this->type = $shopSettings['type'];
            $this->code = $shopSettings['code'];
        }
        return 'add shop settings first';
        
        
    }
    
    private function getApiSettings()
    {
        $businessId = request()->session()->get('business.id');
        return json_decode(Business::select('api_settings')->find($businessId)['api_settings'],true);
        
    }
    
    public function getShopClientCredentialsToken()
    {
        
        if($token = $this->existingValidToken()){
            return $token;
        }
        
        $tokenData = $this->makeRequest('POST','api/v2/auth/admin',[],[
            'base_url' => $this->base_url,
            'grant_type' => 'shop_credentials',
            'email' => $this->userName,
            'password' => $this->password,
            'type' => $this->type,
            'code' => $this->code
        ]);
        
        $this->storeValidToken($tokenData,'shop_credentials');
        return $tokenData->access_token;
    }
    
    
    private function storeValidToken($tokenData,$grantType)
    {
        
        $tokenData->expires_at = now()->addMinutes(60);
        $tokenData->access_token = "{$tokenData->token_type} {$tokenData->access_token}";
        $tokenData->grant_type = $grantType;
        
        session()->put(['shop_credentials' => $tokenData]);
        
    }
    
    private function existingValidToken()
    {
        if(session()->has('shop_credentials')){
            $tokenData = session()->get('shop_credentials');
            if(now()->lt($tokenData->expires_at)){
                return $tokenData->access_token;
            }
        }
        
        return false;
    }
    
}