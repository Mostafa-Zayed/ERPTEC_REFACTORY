<?php 

namespace App\Interfaces;


interface InvoiceSchemeInterface
{
    public function getAll($business_id);
    public function getDefault($business_id,$select = []);
}