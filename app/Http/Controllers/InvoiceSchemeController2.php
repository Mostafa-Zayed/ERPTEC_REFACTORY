<?php

namespace App\Http\Controllers;

use App\Interfaces\InvoiceSchemeInterface;

use App\InvoiceScheme;

class InvoiceSchemeController2 extends Controller
{
    private $invoiceSchemeInterface;
    
    private $columns = [];
    
    private array $options;
    
    private $pluck;
    
    public function __construct(InvoiceSchemeInterface $invoiceSchemeInterface)
    {
        $this->invoiceSchemeInterface = $invoiceSchemeInterface;
    }
    
    
    public function index()
    {
        $businessId = request()->session()->get('business.id');
        
        $invoiceSchemes = $this->invoiceSchemeInterface->getAll($businessId);
        
        if($this->pluck = ['name','id']) {

            return $invoiceSchemes->pluck('name','id');
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