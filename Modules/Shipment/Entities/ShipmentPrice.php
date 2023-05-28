<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Entities\Company as ShipmentCompany;
use Modules\Shipment\Entities\Account as ShipmentAccount;
use Modules\Shipment\Entities\Zone;
use App\Business;

class ShipmentPrice extends Model
{
    protected $table = 'shipment_prices';
    
    protected $fillable = ['value','extra','cost','shipment_company_id','shipment_account_id','business_id','zone_id'];
    
    /**
     * relationship with shipment company
     */
     
    public function shipmentCompany() 
    {
        return $this->belongsTo(ShipmentCompany::class,'shipment_company_id','id');
    }
    
    /**
     * relationship with shipment accounts
     */
    public function account()
    {
        return $this->belongsTo(ShipmentAccount::class,'shipment_account_id','id')->withDefault();
    }
    
    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }
    
    public function zone()
    {
        return $this->belongsTo(Zone::class,'zone_id','id');
    }
}
