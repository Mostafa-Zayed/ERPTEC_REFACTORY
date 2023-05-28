<?php

namespace App\Http\Controllers;

use App\Interfaces\BusinessLocationInterface;


class BusinessLocationController2 extends Controller
{
    
    private $businessLocationInterface;
    
    
    
    public function __construct(BusinessLocationInterface $businessLocationInterface)
    {
        $this->businessLocationInterface = $businessLocationInterface;
    }
    
    
    public function index()
    {
        $businessid = request()->session()->get('business.id');
        
    }
    
    
    public function create()
    {
        
    }
    
    
    public function store()
    {
        
    }
}