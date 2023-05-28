<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\Event' => [
        //     'App\Listeners\EventListener',
        // ],
        \App\Events\TransactionPaymentAdded::class => [
            \App\Listeners\AddAccountTransaction::class,
        ],

        \App\Events\TransactionPaymentUpdated::class => [
            \App\Listeners\UpdateAccountTransaction::class,
        ],

        \App\Events\TransactionPaymentDeleted::class => [
            \App\Listeners\DeleteAccountTransaction::class,
        ],
        
        'business.created' => [
            \App\Listeners\AssigneAdminRoleToBusiness::class,
            \App\Listeners\AssigneCashierRoleToBusiness::class,
            \App\Listeners\GenerateContactsReferenceCount::class,
            \App\Listeners\AddInvoiceSchemaToBusiness::class,
            \App\Listeners\AddInvoiceLayoutToBusiness::class,
            // \App\Listeners\AddBarcodeSettingsToBusiness::class,
            \App\Listeners\AddDefaultUnitToBusiness::class,
            \App\Listeners\AddNotificationTemplatesToBusiness::class,
            // \App\Listeners\AddLocationToBusiness::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
