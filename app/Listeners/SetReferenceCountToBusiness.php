<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\ReferenceCount;
use Illuminate\Support\Facades\DB;

class SetReferenceCountToBusiness
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($business)
    {
        $businessId = !empty($business) ? $business->id : request()->session()->get('user.business_id');
        $ref = ReferenceCount::where('ref_type', 'contacts')->where('business_id', $businessId)->first();
        if (!empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            return $ref->ref_count;
        } else {
            $new_ref = ReferenceCount::create([
                'ref_type' => 'contacts',
                'business_id' => $businessId,
                'ref_count' => 1
            ]);
            
            $ref_digits =  str_pad($new_ref->ref_count, 4, 0, STR_PAD_LEFT);
            return $new_ref->ref_count;
        }
        
        $prefix = '';
        if (!empty($business->ref_no_prefixes)) {
            $prefixes = $business->ref_no_prefixes;
            $prefix = !empty($prefixes['contacts']) ? $prefixes['contacts'] : '';
        }
        $ref_digits =  str_pad($new_ref->ref_count, 4, 0, STR_PAD_LEFT);
        
        if (!in_array('contacts', ['contacts', 'business_location', 'username'])) {
            $ref_year = \Carbon::now()->year;
            $ref_number = $prefix . $ref_year . '/' . $ref_digits;
        } else {
            $ref_number = $prefix . $ref_digits;
        }
        return $new_ref->ref_count;
    }
}
