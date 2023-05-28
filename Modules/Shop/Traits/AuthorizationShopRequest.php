<?php

namespace Modules\Shop\Traits;

use Modules\Shop\Services\ShopAuthenticationService;

trait AuthorizationShopRequest
{
    public function resolveAuthorization(&$queryParams,&$formParams,&$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers['Authorization'] = $accessToken;
    }
    
    
    public function resolveAccessToken()
    {
        $authenticationService = resolve(ShopAuthenticationService::class);
        
        return $authenticationService->getShopClientCredentialsToken();
    }
}