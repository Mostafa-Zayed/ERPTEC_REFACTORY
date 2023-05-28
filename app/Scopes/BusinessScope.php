<?php

namespace App\Scopes;

use App\Http\Traits\BusinessService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class BusinessScope implements Scope
{
    use BusinessService;
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('business_id','=',$this->getBusinessId());
    }
}