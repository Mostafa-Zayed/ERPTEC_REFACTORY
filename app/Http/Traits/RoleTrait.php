<?php

namespace App\Http\traits;

trait RoleTrait
{
    
    public function isAuthenticatedUserHaAdminRole($businessId = null ,$roles = null)
    {
        $businessId = ! empty($businessId) ? $businessId : request()->session()->get('user.business_id');
        $adminRole = 'Admin#'.$businessId;
        $userRoles = ! empty(auth()->user()->roles) ? auth()->user()->roles : null;
      //  dd($userRoles);
        foreach($userRoles as $role){
            if ($role->name === $adminRole){
                   return true;
                }
        }
        
        return false;
    }
}