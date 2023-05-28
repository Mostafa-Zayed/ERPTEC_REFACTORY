<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Spatie\Permission\Models\Role;
use App\User;

class AssigneAdminRoleToBusiness
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($business)
    {
        $user = User::find($business->owner_id);

        //create Admin role and assign to user
        $role = Role::create([ 'name' => 'Admin#' . $business->id,
                            'business_id' => $business->id,
                            'guard_name' => 'web', 'is_default' => 1
                        ]);
        $user->assignRole($role->name);
    }
}
