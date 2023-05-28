<?php

namespace App\Repositories;

use App\Interfaces\BusinessLocationInterface;
use App\BusinessLocation;
use App\Interfaces\InvoiceSchemeInterface;
use App\Interfaces\InvoiceLayoutInterface;
use App\Interfaces\ReferenceCountInterface;
use App\Interfaces\BusinessInterface;
use App\Business;
use App\Traits\BusinessUtil;

class BusinessLocationRepository implements BusinessLocationInterface
{
    use BusinessUtil;
    protected $invoiceSchemeInterface;
    protected $invoiceLayoutInterface;
    private   $referenceCountInterface;
    private   $businessInterface;
    
    public function __construct(
        InvoiceSchemeInterface  $invoiceSchemeInterface,
        InvoiceLayoutInterface  $invoiceLayoutInterface,
        ReferenceCountInterface $referenceCountInterface,
        BusinessInterface       $businessInterface
    )
    {
        $this->invoiceSchemeInterface = $invoiceSchemeInterface;
        $this->invoiceLayoutInterface = $invoiceLayoutInterface;
        $this->referenceCountInterface = $referenceCountInterface;
        $this->businessInterface = $businessInterface;
    }
    
    
    public function addLocation($business_id, &$location_details, $invoice_scheme_id = null, $invoice_layout_id = null)
    {
        $invoice_scheme_id = empty($invoice_scheme_id) ? $this->invoiceLayoutInterface->getDefault($business_id,['id'])->id : $invoice_scheme_id;
        $invoice_layout_id = empty($invoice_scheme_id) ? $this->invoiceSchemeInterface->getDefault($business_id,['id'])->id : $invoice_scheme_id;
        
        $ref_count = $this->referenceCountInterface->setReferenceCount('business_location', $business_id);
        
        $location_id = $this->referenceCountInterface->addReferenceCount('business_location', $ref_count, $business_id);
        
        $payment_types = self::getPaymentTypes();
        
        $location_payment_types = [];
        
        foreach ($payment_types as $key => $value) {
            $location_payment_types[$key] = [
                'is_enabled' => 1,
                'account' => null
            ];
        }
        
        $location_details['business_id'] = $business_id;
        $location_details['invoice_scheme_id'] = $invoice_scheme_id;
        $location_details['invoice_layout_id'] = $invoice_layout_id;
        $location_details['sale_invoice_layout_id'] = $invoice_layout_id;
        $location_details['location_id'] = $location_id;
        $location_details['default_payment_accounts'] = json_encode($location_payment_types);
        return BusinessLocation::create($location_details);
    }
    
}