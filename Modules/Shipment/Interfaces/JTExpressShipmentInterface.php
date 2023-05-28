<?php

namespace App\Interfaces\Shipment;

interface JTExpressShipmentInterface
{
    public function index();
    
    public function getEnvData($env);
    
    public function getContentDigest($customerCode,$password,$privateKey);
    
    public function getHeaderDigest($order,$privateKey);
    
    public function updateSettings($inputs,$id);
    
    public function getOrderInfo($orderId);
    
    public function getContactInfo($contactId);
    
    public function getConteactAddress($addressId);
    
    public function generateOrderDetails($order,$contact,$address,$settings);
    
    public function sendRequest($inputs,$order);
    
    public function sendTestOrder();
    
    public function printOrder($id);
    
    public function cancelOrder($id);
}