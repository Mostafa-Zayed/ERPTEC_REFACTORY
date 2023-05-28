<?php

namespace Modules\Shipment\Services;

use App\Traits\ConsumesExternalServices;

class FedexExpressService
{
    use ConsumesExternalServices;
    
    public static $BASE_URL;
    
    public function __construct()
    {
        self::$BASE_URL = config('shipment.fedex_express.base_url');
    }
    
    public function resolveAuthorization(&$queryParams, &$formParams, &$headers)
    {
        
    }
    
    public function decodeResponse($response)
    {
        
    }
    
    public function checkIfErrorResponse($response)
    {
        
    }
}