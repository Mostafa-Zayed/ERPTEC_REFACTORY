<?php

namespace App\Http\Controllers;

use App\Interfaces\InvoiceLayoutInterface;

use App\InvoiceLayout;

class InvoiceLayoutController2 extends Controller
{
    private $invoiceLayoutInterface;
    
    private $columns = [];
    
    private array $options;
    
    private $pluck;
    
    public function __construct(InvoiceLayoutInterface $invoiceLayoutInterface)
    {
        $this->invoiceLayoutInterface = $invoiceLayoutInterface;
    }
    
    
    public function index()
    {
        $businessId = request()->session()->get('business.id');
        
        $invoiceLayouts = $this->invoiceLayoutInterface->getAll($businessId);
        
        if($this->pluck = ['name','id']) {

            return $invoiceLayouts->pluck('name','id');
        }
        
        
        
    }
    
    
    public function generateColumns(array $columns)
    {
        $str = '';
        foreach($columns as $column) {
            $str .= '\'' . $column . '\',';
        }
        
        return  rtrim($str,',');
    }
    
    
}