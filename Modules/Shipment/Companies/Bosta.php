<?php

namespace Modules\Shipment\Companies;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Composer\Semver\Comparator;
use Modules\Shipment\Entities\Account;
use App\System;
use Modules\Shipment\Entities\Account as ShipmentAccount;
use Modules\Shipment\Interfaces\ShipmentInterface;

class Bosta implements ShipmentInterface
{
    
    
    public function send()
    {
        
    }
}