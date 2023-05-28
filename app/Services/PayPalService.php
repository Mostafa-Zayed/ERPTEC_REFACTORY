<?php

namespace App\Services;

use App\Traits\ConsumesExternalServices;

class PayPalService
{
    use ConsumesExternalServices;
    private $baseUri;
    
    private $clientId;
    
    private $clientSecret;
    
    public function __construct()   
    {
        
    }
}