<?php

namespace Modules\Shipment\Companies\Types;

use Modules\Shipment\Interfaces\Shipment;
use Modules\Shipment\Companies\Aramex;

class AramexCompany extends Shipment
{
    function createCompany()
    {
        return new Aramex();
    }
}