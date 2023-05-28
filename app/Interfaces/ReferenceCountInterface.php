<?php 

namespace App\Interfaces;

interface ReferenceCountInterface
{
    public function setReferenceCount($type,$business_id = null);
    public function addReferenceCount($type,$ref_count,$business_id = null, $default_prefix = null);
}