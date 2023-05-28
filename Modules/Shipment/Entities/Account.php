<?php

namespace Modules\Shipment\Entities;

use Illuminate\Database\Eloquent\Model;
use App\Business;
use Modules\Shipment\Entities\Company as ShipmentCompany;
use App\Transaction;

class Account extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shipment_accounts';
    
    public function business()
    {
        return $this->belongsTo(Business::class,'business_id','id');
    }
    
    
    /**
     * relationship with shipment company
     */
     
    public function shipmentCompany() 
    {
        return $this->belongsTo(ShipmentCompany::class,'shipment_company_id','id');
    }
    
    /**
     * relationship with transaction
     */
    public function orders() 
    {
        return $this->hasMany(Transaction::class,'shipment_account_id','id');
    }
    
}
