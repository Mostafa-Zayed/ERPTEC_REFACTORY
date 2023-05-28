<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Entities\Account as ShipmentAccount;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_companies';
    
    protected $fillable  = ['settings','name','description','image','type','status','business_id'];
    /**
     * relationship with shipment accounts
     */
    public function accounts()
    {
        return $this->hasMany(ShipmentAccount::class,'','id')->withDefault();
    }
    
    public static function getSettings(Company $company)
    {
        return config('shipments.' . $company->name . 'settings');
    }
}
