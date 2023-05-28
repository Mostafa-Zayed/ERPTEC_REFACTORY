<?php

namespace Modules\Shipment\Services;

use App\Traits\ConsumesExternalServices;

class XturboService
{
    use ConsumesExternalServices;
    
    public static $BASE_URL;
    
    public function __construct()
    {
        self::$BASE_URL = config('shipment.xturbo.base_url');
    }
    
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        $accessToken = $this->resolveAccessToken();
        $headers['Authorization'] = $accessToken;
    }
    
    public function decodeResponse($response)
    {
        
    }
    
    public function checkIfErrorResponse($response)
    {
        
    }
    
    private function resolveAccessToken()
    {
        
    }
}