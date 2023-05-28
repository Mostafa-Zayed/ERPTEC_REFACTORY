<?php 

namespace App\Interfaces;


interface InvoiceLayoutInterface
{
    public function getDefault($business_id,$select = []);
}