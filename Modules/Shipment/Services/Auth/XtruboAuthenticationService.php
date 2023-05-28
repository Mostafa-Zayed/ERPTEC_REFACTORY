<?php

namespace Modules\Shipment\Services;

use App\Traits\ConsumesExternalServices;
use Modules\Shipment\Traits\InteractsWithShopResponse;
use Modules\Entities\Account as ShipmentAccount;

class ShopAuthenticationService
{
    use ConsumesExternalServices;
    use InteractsWithShopResponse;
    
    private static $baseUrl;
    private static $email;
    private static $password;
    
    public function __construct()
    {
        self::$baseUrl = config('shipment.compaines.xturbo.baseUrl');
    }
    
    private function getApiSettings()
    {
        $businessId = request()->session()->get('business.id');
        
        $settings = json_decode(ShipmentAccount::where('business_id',$businessId)->select('id','name','settings')->first(),true);
        
        self::$email = $settings['email'];
        self::$password = $settings['password'];
    }
    
    public function getShopClientCredentialsToken()
    {
        if($token = $this->existingValidToken()){
            return $token;
        }
        
        $tokenData = $this->makeRequest('POST','login',[],[
            'email' => $this->userName,
            'password' => $this->password,
        ]);
        
        $this->storeValidToken($tokenData,'xturbo_credentials');
        return $tokenData->access_token;
    }
    
    private function existingValidToken()
    {
        if(session()->has('xturbo_credentials')){
            $tokenData = session()->get('xturbo_credentials');
            if(now()->lt($tokenData->expires_at)){
                return $tokenData->access_token;
            }
        }
        
        return false;
    }
}