<?php

namespace App\Repositories;

use App\Interfaces\ReferenceCountInterface;
use App\User;
use Carbon\Carbon;
use App\Http\Traits\Util;
use App\Business;
use Spatie\Permission\Models\Role;
use App\Http\Traits\BusinessService;
use App\Repositories\RoleRepository;
use App\ReferenceCount;

class ReferenceCountRepository implements ReferenceCountInterface
{
    public function setReferenceCount($type, $businessId = null)
    {
        $businessId = ! empty($businessId) ? $businessId : request()->session()->get('user.business_id');
        $ref = ReferenceCount::where('ref_type', $type)->where('business_id', $businessId)->first();
        
        if (!empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            return $ref->ref_count;
        } else {
            $ref = ReferenceCount::create([
                'ref_type' => $type,
                'business_id' => $businessId,
                'ref_count' => 1
            ]);
            return $ref->ref_count;    
        }
        
        
    }
    
    public function addReferenceCount($type, $ref_count, $business_id = null, $default_prefix = null)
    {
        $prefix = '';

        if (session()->has('business') && !empty(request()->session()->get('business.ref_no_prefixes')[$type])) {
            $prefix = request()->session()->get('business.ref_no_prefixes')[$type];
        }
        
        if (!empty($business_id)) {
            $business = Business::select('id','ref_no_prefixes')->find($business_id);
            $prefixes = $business->ref_no_prefixes;
            $prefix = !empty($prefixes[$type]) ? $prefixes[$type] : '';
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