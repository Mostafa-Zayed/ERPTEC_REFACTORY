<?php

namespace App\Repositories;

use App\Interfaces\InvoiceLayoutInterface;
use App\InvoiceLayout;
use Illuminate\Support\Facades\DB;

class InvoiceLayoutRepository implements InvoiceLayoutInterface
{
    public function getAll($businessId)
    {
        return DB::table('invoice_layouts')->where('business_id',$businessId)->get();
    }
    
    public function getDefault($business_id,$select = [])
    {
        $query = InvoiceLayout::forbusiness($business_id)->isdefault();
        
        if(! empty($select))
            $query = $query->select($select);
            
        return $query->first();
    }
}