<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Contact;
use App\ReferenceCount;

class GenerateContactsReferenceCount
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    private const RESOURCE = 'contacts' ;
    
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
        $ref = ReferenceCount::where('ref_type', self::RESOURCE)->where('business_id', $businessId)->first();
        if (!empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            return $ref->ref_count;
        } else {
            $new_ref = ReferenceCount::create([
                'ref_type' => self::RESOURCE,
                'business_id' => $businessId,
                'ref_count' => 1
            ]);
        }
        
        $prefix = '';
        if (!empty($business->ref_no_prefixes)) {
            $prefixes = $business->ref_no_prefixes;
            $prefix = !empty($prefixes[self::RESOURCE]) ? $prefixes[self::RESOURCE] : '';
        }
        $ref_digits =  str_pad($new_ref->ref_count, 4, 0, STR_PAD_LEFT);
        
        if (!in_array(self::RESOURCE, ['contacts', 'business_location', 'username'])) {
            $ref_year = \Carbon::now()->year;
            $ref_number = $prefix . $ref_year . '/' . $ref_digits;
        } else {
            $ref_number = $prefix . $ref_digits;
        }
        
        $customer = [
                        'business_id' => $businessId,
                        'type' => 'customer',
                        'name' => 'Walk-In Customer',
                        'created_by' => $business->owner_id,
                        'is_default' => 1,
                        'contact_id' => $ref_number,
                        'credit_limit' => 0
                    ];
        Contact::create($customer);
        
    }
}
