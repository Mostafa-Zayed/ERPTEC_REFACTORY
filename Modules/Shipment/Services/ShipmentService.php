<?php

namespace Modules\Shipment\Services;

// use App\Traits\ConsumesExternalServices;
use Modules\Shipment\Interfaces\ShipmentInterface;

class ShipmentService
{
    // use ConsumesExternalServices;     
    
    private $company;
    
    public function __construct(ShipmentInterface $company)
    {
        $this->company = $company;
    }
    
    public function send()
    {
        return $this->company->send();
    }
}