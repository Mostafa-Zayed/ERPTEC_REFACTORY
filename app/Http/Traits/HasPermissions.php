<?php

namespace App\Http\Traits;

trait HasPermissions
{
    public function businessCan($permissions)
    {
        foreach ($permissions as $permission) {
            if (! auth()->user()->can($permission)) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        return true;
    }
}