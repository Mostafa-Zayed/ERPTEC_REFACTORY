<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country;
use App\Models\State;
use App\Business;
use App\Contact;
use App\Models\City;

class Address extends Model
{
    protected $table = 'addresses';
    
    protected $fillable = ['name','mobile','phone','is_default','contact_id','business_id','country_id','city_id','state_id','content'];
    
    public function country()
    {
        return $this->belongsTo(Country::class,'country_id','id');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class,'state_id','id');
    }
    
    public function city()
    {
        return $this->belongsTo(City::class,'city_id','id');
    }
    
    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }
    
    public function contact()
    {
        return $this->belongsTo(Contact::class,'contact_id','id');
    }
}
