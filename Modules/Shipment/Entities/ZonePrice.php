<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Entities\Company;
use Modules\Shipment\Entities\Account;
use App\Business;

class ZonePrice extends Model
{
    protected $fillable = [];
    
    public function company()
    {
        return $this->belongsTo('Modules\Shipment\Entities\Company','shipment_company_id ','id');
    }
    
    public function account()
    {
        return $this->belongsTo('Modules\Shipment\Entities\Account','shipment_account_id ','id');
    }
    
    public function business()
    {
       return $this->belongsTo('App\Business','business_id ','id'); 
    }
}
