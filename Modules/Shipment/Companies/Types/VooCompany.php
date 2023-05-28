<?php

namespace Modules\Shipment\Companies\Types;

use Modules\Shipment\Interfaces\Shipment;
use Modules\Shipment\Companies\Voo;

class VooCompany extends Shipment
{
    function createCompany()
    {
        return new Voo();
    }
}