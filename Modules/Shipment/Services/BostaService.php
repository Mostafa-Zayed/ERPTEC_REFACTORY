<?php

namespace Modules\Shipment\Services;

use App\Traits\ConsumesExternalServices;
use Modules\Shipment\Traits\Auth\AuthorizesBostaShipmentRequest;
use Modules\Shipment\Traits\InteractsWithBostaShipmentResponse;

class bostaService
{
    use ConsumesExternalServices;
    use AuthorizesBostaShipmentRequest;
    use InteractsWithBostaShipmentResponse;
    
    public $base_url;
    public $apiVersion;
    
    public function __construct()
    {
        $this->base_url = config('shipment.bosta.base_url');
    }
    
    public function getAreas()
    {
        return $this->makeRequest('GET','areas');
    }
    
}