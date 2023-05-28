<?php

namespace Modules\Shipment\Services;

use App\Traits\ConsumesExternalServices;
use Modules\Shipment\Traits\Auth\AuthorizesVooShipmentRequest;
use Modules\Shipment\Traits\InteractsWithVooShipmentResponse;

class VooService
{
    use ConsumesExternalServices;
    use AuthorizesVooShipmentRequest;
    use InteractsWithVooShipmentResponse;
    
    public $base_url;
    public $apiVersion;
    
    public function __construct()
    {
        $this->base_url = config('shipment.voo.base_url');
    }
    
    public function getAreas()
    {
        return $this->makeRequest('GET','areas');
    }
    
}