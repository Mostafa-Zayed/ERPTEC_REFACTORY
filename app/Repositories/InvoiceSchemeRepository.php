<?php

namespace App\Repositories;

use App\Interfaces\InvoiceSchemeInterface;
use App\InvoiceScheme;
use Illuminate\Support\Facades\DB;

class InvoiceSchemeRepository implements InvoiceSchemeInterface
{
    public function getAll($business_id)
    {
        return DB::table('invoice_schemes')->where('business_id',$business_id)->get();
    }
    
    public function getDefault($business_id,$select = [])
    {
        $query = InvoiceScheme::forbuiness($business_id)->isdefault();
        if(! empty($select))
            $query = $query->select($select);
            
        return $query->first();
    }
}