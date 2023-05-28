<?php

namespace App\Repositories;

use App\Http\Traits\BusinessService;
use Spatie\Permission\Models\Role;


class RoleRepository 
{
    
    public function addRoleWithName(string $name,$business_id,bool $is_default = true)
    {
        return Role::create(
            [ 
                'name' => ucfirst($name) . '#' . $business_id,
                'business_id' => $business_id,
                'guard_name' => 'web',
                'is_default' => $is_default ? 1 : 0
            ]
        );
    }
    
    public function addAdminForBusiness($business_id)
    {
        return $this->addRoleWithName('admin',$business_id,true);
    }
    
    public function addCashierForBusiness($business_id)
    {
        return $this->addRoleWithName('cashier',$business_id,false);
    }
    
    
}