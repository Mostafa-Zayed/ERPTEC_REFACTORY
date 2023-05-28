<?php

namespace App;

use App\Scopes\BusinessScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brands extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Return list of brands for a business
     *
     * @param int $business_id
     * @param boolean $show_none = false
     *
     * @return array
     */
    public static function forDropdown($business_id, $show_none = false, $filter_use_for_repair = false)
    {
        $query = Brands::where('business_id', $business_id);

        if ($filter_use_for_repair) {
            $query->where('use_for_repair', 1);
        }

        $brands = $query->orderBy('name', 'asc')
                    ->pluck('name', 'id');

        if ($show_none) {
            $brands->prepend(__('lang_v1.none'), '');
        }

        return $brands;
    }
    
    public static function boot()
    {
        parent::boot();
        static::addGlobalScope(new BusinessScope());
    }
    
    public function scopeRepairModule(Builder $query): Builder
    {
        return $query->where('use_for_repair','=',1);
    }
    
    public function shopBrand()
    {
        return $this->hasOne('Modules\Shop\Entities\ShopBrand','brand_id','id')->withDefault();
    }
    
    public function getLogoUrlAttribute()
    {
        if($this->logo){
            return asset('public/uploads/' . $this->logo);
        }
        
        return null;
    }
}
