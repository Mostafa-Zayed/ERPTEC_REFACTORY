<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;

class ShopBrand extends Model
{
    protected $fillable = ['business_id','meta_title','uuid','meta_description','brand_id'];
    
    public function brand()
    {
        return $this->belongsTo('App\Brands','brand_id','id');
    }
}
