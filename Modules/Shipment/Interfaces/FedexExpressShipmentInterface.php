<?php

namespace App\Interfaces\Shipment;

interface FedexExpressShipmentInterface
{
    
    // public function index();
    
    // public function makeAuth();
    
    // // public function makeRequest($id);
    
    // public function createShipment($orderId);
    
    public function cityList();
    
    
    public function updateSettings($request,$id);
    
    /*
    * this function create new Shipment 
    * @param $id
    */
    public function createShipment($id);
    
    /*
    * this function get order pdf
    */
    public function getFedexOrderPdf($id);
}