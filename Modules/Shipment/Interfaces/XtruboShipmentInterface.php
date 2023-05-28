<?php 

namespace App\Interfaces\Shipment;

interface XtruboShipmentInterface extends ShipmentInterface
{
    public function getCities();
    
    public function makeRequest($id);
    
    public function getShipmentOrderPdf($shipmentId);
}