<?php 

namespace App\Http\Controllers;

use App\Interfaces\SellPriceGroupInterface;

class SellPriceGroupController extends Controller
{
    private $sellPriceGroupInterface;
    
    public function __construct(SellPriceGroupInterface $sellPriceGroupInterface)
    {
        $this->sellPriceGroupInterface = $sellPriceGroupInterface;
    }
    
    public function index()
    {
        $businessId = request()->session()->get('business.id');
        
        $sellGroups = $this->sellPriceGroupInterface->getAll($businessId);
        
    }
}