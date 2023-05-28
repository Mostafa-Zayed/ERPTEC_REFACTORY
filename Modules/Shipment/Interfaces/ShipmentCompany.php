<?php

namespace Modules\Shipment\Interfaces;

interface ShipmentCompany
{
    public function createOrder($order_id);
    public function getOrderShipmentStatus($order_number);
    public function cancelOrder($order_id);
}