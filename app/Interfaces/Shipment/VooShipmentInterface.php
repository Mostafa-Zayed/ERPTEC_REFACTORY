<?php

namespace App\Interfaces\Shipment;

interface VooShipmentInterface extends ShipmentInterface
{
    public function getAreas();
    
    public function makeRequest($id);
    
    public function getOrderInfo($id);
    
    public function test();
    
    /*
    *  get all prices of the couriers for the normal local order
    */
    public function getLocalPrices($areaId);
    
    public function getOrderAWB($orderId);
    
    public function createNormalOrder($transactionId);
}