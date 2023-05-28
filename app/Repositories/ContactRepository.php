<?php

namespace App\Repositories;

use App\Interfaces\ContactInterface;
use App\Category;
use App\Http\Traits\BusinessService;
use App\Http\Traits\Util;
use App\Contact;

class ContactRepository implements ContactInterface
{
    
    public function getContactByContactId(string $contactId)
    {
        
    }
    
    public static function searchByContactId(string $contactId ,$businessId = null)
    {
        $businessId = empty($businessId) ? request()->session()->get('user.business_id') : $businessId;
        
        return Contact::where('business_id', $businessId)->where('contact_id', $contactId)->count();
    }
    
    
    /**
     * Generates reference number
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    public static function generateReferenceNumber($type, $ref_count, $business_id = null, $default_prefix = null)
    {
        $prefix = '';

        if (session()->has('business') && !empty(request()->session()->get('business.ref_no_prefixes')[$type])) {
            $prefix = request()->session()->get('business.ref_no_prefixes')[$type];
        }
        if (!empty($business_id)) {
            $business = Business::find($business_id);
            $prefixes = $business->ref_no_prefixes;
            $prefix = $prefixes[$type];
        }

        if (!empty($default_prefix)) {
            $prefix = $default_prefix;
        }

        $ref_digits =  str_pad($ref_count, 4, 0, STR_PAD_LEFT);

        if (!in_array($type, ['contacts', 'business_location', 'username'])) {
            $ref_year = \Carbon::now()->year;
            $ref_number = $prefix . $ref_year . '/' . $ref_digits;
        } else {
            $ref_number = $prefix . $ref_digits;
        }

        return $ref_number;
    }
}