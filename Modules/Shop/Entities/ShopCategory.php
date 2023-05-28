<?php

namespace Modules\Shop\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Category;

class ShopCategory extends Model
{
    protected $guarded = ['id'];
     
    public function erpCategory() 
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
