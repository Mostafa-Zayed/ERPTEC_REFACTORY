<?php

namespace Modules\Shipment\Companies;

use Modules\Shipment\Interfaces\ShipmentCompany;

class Aramex implements ShipmentCompany
{
    public function createOrder($order_id)
    {
        dd($order_id);
    }
    public function getOrderShipmentStatus($order_number)
    {
        
    }
    public function cancelOrder($order_id)
    {
        
    }
}