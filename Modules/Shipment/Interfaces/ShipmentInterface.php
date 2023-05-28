<?php

namespace Modules\Shipment\Interfaces;

interface ShipmentInterface
{
    public function createOrder($order_id);
    
    // public function getAreas();
    
    // public function getZones();
    
    public function getShipmnetOrderStatus($order_number);
    
    public function getOrderInvoice($order_number);
}