<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\InvoiceScheme;

class AddInvoiceSchemaToBusiness
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
                InvoiceScheme::create(['name' => 'Default',
                            'scheme_type' => 'blank',
                            'prefix' => '',
                            'start_number' => 1,
                            'total_digits' => 4,
                            'is_default' => 1,
                            'business_id' => $business->id
                        ]);
    }
}
