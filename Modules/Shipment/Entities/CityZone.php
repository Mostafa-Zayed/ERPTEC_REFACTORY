<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Business;
use Modules\Shipment\Entities\Zone;
use App\Models\State;

class CityZone extends Model
{
    protected $table = 'city_zones';
    protected $fillable = ['business_id','state_id','zone_id'];
    
    
    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }
    
    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id','id');
    }
    
    public function state()
    {
        return $this->belongsTo(State::class,'state_id','id');
    }
}
