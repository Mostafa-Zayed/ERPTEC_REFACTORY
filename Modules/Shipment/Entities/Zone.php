<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    protected $table = 'zones';
    
    protected $fillable = array('name', 'name_ar', 'desc','desc_ar','business_id');
    
    public static function forDropdown($business_id, $show_none = false)
    {
        $brands = Zone::where('business_id',$business_id)->pluck('name', 'id');

        if ($show_none) {
            $brands->prepend(__('lang_v1.none'), '');
        }

        return $brands;
    }
}
