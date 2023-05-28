<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Permission\Models\Role;

class AssigneCashierRoleToBusiness
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
        $cashier_role = Role::create([ 'name' => 'Cashier#' . $business->id,
                            'business_id' => $business->id,
                            'guard_name' => 'web'
                        ]);
        $cashier_role->syncPermissions(['sell.view', 'sell.create', 'sell.update', 'sell.delete', 'access_all_locations', 'view_cash_register', 'close_cash_register']);
    }
}
