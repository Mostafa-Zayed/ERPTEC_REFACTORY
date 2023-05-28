<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\InvoiceLayout;

class AddInvoiceLayoutToBusiness
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
               InvoiceLayout::create(['name' => 'Default',
                        'header_text' => null,
                        'invoice_no_prefix' => 'Invoice No.',
                        'invoice_heading' => 'Invoice',
                        'sub_total_label' => 'Subtotal',
                        'discount_label' => 'Discount',
                        'tax_label' => 'Tax',
                        'total_label' => 'Total',
                        'show_landmark' => 1,
                        'show_city' => 1,
                        'show_state' => 1,
                        'show_zip_code' => 1,
                        'show_country' => 1,
                        'highlight_color' => '#000000',
                        'footer_text' => '',
                        'is_default' => 1,
                        'business_id' => $business->id,
                        'invoice_heading_not_paid' => '',
                        'invoice_heading_paid' => '',
                        'total_due_label' => 'Total Due',
                        'paid_label' => 'Total Paid',
                        'show_payments' => 1,
                        'show_customer' => 1,
                        'customer_label' => 'Customer',
                        'table_product_label' => 'Product',
                        'table_qty_label' => 'Quantity',
                        'table_unit_price_label' => 'Unit Price',
                        'table_subtotal_label' => 'Subtotal',
                        'date_label' => 'Date'
                    ]);
    }
}
