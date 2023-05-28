<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class InvoiceScheme extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Returns list of invoice schemes in array format
     */
    public static function forDropdown($business_id)
    {
        $dropdown = InvoiceScheme::where('business_id', $business_id)
                                ->pluck('name', 'id');

        return $dropdown;
    }

    /**
     * Retrieves the default invoice scheme
     */
    public static function getDefault($business_id)
    {
        $default = InvoiceScheme::where('business_id', $business_id)
                                ->where('is_default', 1)
                                ->first();
        return $default;
    }
    
    public function scopeForBusiness(Builder $query,$business_id)
    {
        return $query->where('business_id','=',$business_id);
    }
    
    public function scopeIsDefault(Builder $query)
    {
        return $query->where('is_default','=',1);
    }
    
    public function scopeLatest(Builder $query)
    {
        return $query->orderBy(static::CREATED_AT,'desc');
    }
}
