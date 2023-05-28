<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Address;

class State extends Model {
    protected $table = 'states';
    protected $fillable = array('name','name_ar','city_id');
    public $timestamps = false;


    public function city()
    {
        return $this->belongsTo('App\Models\City','city_id','id')->withDefault();
    }
    
    public function addresses()
    {
        return $this->hasMany(Address::class,'state_id','id')->withDefault();
    }
}
