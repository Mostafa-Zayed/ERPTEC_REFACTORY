<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Barcode;

class AddBarcodeSettingsToBusiness
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
                Barcode::create(['name' => 'Default',
                        'description' => '',
                        'width' => 37.29,
                        'height' => 25.93,
                        'top_margin' => 5,
                        'left_margin' => 5,
                        'row_distance' => 1,
                        'col_distance' => 1,
                        'stickers_in_one_row' => 4,
                        'is_default' => 1,
                        'business_id' => $business->id
                    ]);
    }
}
