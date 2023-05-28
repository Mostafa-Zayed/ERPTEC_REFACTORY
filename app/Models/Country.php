<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Business;
use App\Address;
use App\Models\City;

class Country extends Model
{
    protected $fillable = ['name_ar', 'country_name', 'country_code', 'nicename', 'iso3', 'numcode', 'photo', 'phonecode', 'status'];
    public $timestamps = false;
   

    public static function forDropdown($business_id, $show_none = false)
    {
        $ids = '';
        $business_id = request()->session()->get('user.business_id');
        if($business_id){
            
          $business = Business::where('id', $business_id)->first();
          
           $ids = $business->country;
        }
     
        if($ids){
            
              $brands = Country::whereIn('id',$ids)->where('status',1)->pluck('country_name', 'id');
            
        }else{
            
            
              $brands = Country::where('status',1)->pluck('country_name', 'id');
            
        }
        
      

        if ($show_none) {
            $brands->prepend(__('lang_v1.none'), '');
        }

        return $brands;
    }
    
    public static function forDropdownname($business_id, $show_none = false)
    {
        
        
          $ids = '';
        $business_id = request()->session()->get('user.business_id');
        if($business_id){
            
          $business = Business::where('id', $business_id)->first();
          
           $ids = $business->country;
        }
     
        if($ids){
            
           $brands = Country::whereIn('id',$ids)->where('status',1)->pluck('country_name', 'country_name');
              
              
            
        }else{
            
            $brands = Country::where('status',1)->pluck('country_name', 'country_name');   
         
            
        }
        
      
      
     

        if ($show_none) {
            $brands->prepend(__('lang_v1.none'), '');
        }

        return $brands;
    }
    
    public function addresses()
    {
        return $this->hasMany(Address::class,'country_id','id')->withDefault();
    }
    
    public function cities()
    {
        return $this->hasMany(City::class,'country_id','id')->withDefault();
    }
    
    

}
