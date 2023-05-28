<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddLocationToBusiness
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
    public function handle($business,$locationData = [])
    {
        $layout = InvoiceLayout::where('is_default', 1)
                                    ->where('business_id', $business_id)
                                    ->first();
            $invoice_layout_id = $layout->id;
    }
}
