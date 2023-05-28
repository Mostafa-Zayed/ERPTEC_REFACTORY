<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Unit;

class AddDefaultUnitToBusiness
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
                $unit = [
                    'business_id' => $business->id,
                    'actual_name' => 'Pieces',
                    'short_name' => 'Pc(s)',
                    'allow_decimal' => 0,
                    'created_by' => $business->owner_id
                ];
        Unit::create($unit);
    }
}
