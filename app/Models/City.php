<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\State;
use App\Address;

class City extends Model {
    protected $table = 'cities';
    protected $fillable = array('name','name_ar','country_id','zone_id');
    public $timestamps = false;


    public function country(){
        return $this->belongsTo('App\Models\Country', 'country_id','id');        
    }
    
    public function states()
    {
        return $this->hasMany(State::class,'city_id','id');
    }
    
     public function addresses()
    {
        return $this->hasMany(Address::class,'city_id','id')->withDefault();
    }
}
