<?php

namespace Modules\Shipment\Interfaces;

abstract class Shipment
{
    abstract function createCompany();
    
    public function sendOrder($id)
    {
        $company = $this->createCompany();
        
        $company->createOrder($id);
    }
}



// createor