<?php 


namespace App\Interfaces;


interface BusinessLocationInterface
{
    public function addLocation($business_id,&$location_details, $invoice_scheme_id = null, $invoice_layout_id = null);
}