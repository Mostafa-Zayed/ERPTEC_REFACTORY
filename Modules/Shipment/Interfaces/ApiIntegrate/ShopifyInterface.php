<?php

namespace App\Interfaces\ApiIntegrate;

use Illuminate\Http\Request;

interface ShopifyInterface
{
    public function index(Request $request);
    
    public function apiSettings();
    
    public function updateSettings(Request $request);
    
    public function install(Request $request);
    
    public function token(Request $request);
    
    public function sync($item);
    
    public function addCategory();
    
    public function getLastSync($businessId, $type, $for_humans = true);
    
    /* Customers */
    public function getCustomers();
    
    public function addCustomer();
    
    public function getCustomCollections();
    
    /* Products */
    public function addProducts();
    
    /* Orders */
    public function getOrders();
    
    public function getDraftOrders();
}