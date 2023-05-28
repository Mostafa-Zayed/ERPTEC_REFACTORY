<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Modules\Shipment\Entities\Account as ShipmentAccount;
use Modules\Shipment\Entities\Company as ShipmentCompany;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Notifications\Notifiable;

class Business extends Model
{
    use Notifiable;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'business';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'woocommerce_api_settings'];

    /**
      * The attributes that should be hidden for arrays.
      *
      * @var array
      */
    protected $hidden = [
        'logo',
        'woocommerce_api_settings',
        'updated_at',
        'keyboard_shortcuts',
        'pos_settings',
        "woocommerce_skipped_orders",
        "woocommerce_wh_oc_secret",
        "woocommerce_wh_ou_secret",
        "woocommerce_wh_od_secret",
        "woocommerce_wh_or_secret",
        "manufacturing_settings",
        "essentials_settings",
        "api_settings",
        "enabled_modules",
        "ref_no_prefixes",
        "enable_brand",
        "enable_category",
        "enable_sub_category",
        "enable_price_tax",
        "enable_purchase_status",
        "enable_lot_number",
        "default_unit",
        "enable_sub_units",
        "enable_racks",
        "enable_row",
        "enable_position",
        "enable_editing_product_from_purchase",
        'custom_labels',
        "email_settings",
        "sms_settings",
        "common_settings",
        "weighing_scale_setting",
        "tax_number_1",
        "tax_label_1",
        "tax_number_2",
        "tax_label_2",
        "default_sales_tax",
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'ref_no_prefixes' => 'array',
        'enabled_modules' => 'array',
        'email_settings' => 'array',
        'sms_settings' => 'array',
        'common_settings' => 'array',
        'weighing_scale_setting' => 'array'
    ];

    /**
     * Returns the date formats
     */
    public static function date_formats()
    {
        return [
            'd-m-Y' => 'dd-mm-yyyy',
            'm-d-Y' => 'mm-dd-yyyy',
            'd/m/Y' => 'dd/mm/yyyy',
            'm/d/Y' => 'mm/dd/yyyy'
        ];
    }

    /**
     * Get the owner details
     */
    public function owner()
    {
        return $this->hasOne(\App\User::class, 'id', 'owner_id');
    }

    /**
     * Get the Business currency.
     */
    public function currency()
    {
        return $this->belongsTo(\App\Currency::class);
    }

    /**
     * Get the Business currency.
     */
    public function locations()
    {
        return $this->hasMany(\App\BusinessLocation::class);
    }

    /**
     * Get the Business printers.
     */
    public function printers()
    {
        return $this->hasMany(\App\Printer::class);
    }

    /**
    * Get the Business subscriptions.
    */
    public function subscriptions()
    {
        return $this->hasMany('\Modules\Superadmin\Entities\Subscription');
    }

    /**
     * Creates a new business based on the input provided.
     *
     * @return object
     */
    public static function create_business($details)
    {
        $business = Business::create($details);
        return $business;
    }

    /**
     * Updates a business based on the input provided.
     * @param int $business_id
     * @param array $details
     *
     * @return object
     */
    public static function update_business($business_id, $details)
    {
        if (!empty($details)) {
            Business::where('id', $business_id)
                ->update($details);
        }
    }

    public function getBusinessAddressAttribute() 
    {
        $location = $this->locations->first();
        $address = $location->landmark . ', ' .$location->city . 
        ', ' . $location->state . '<br>' . $location->country . ', ' . $location->zip_code;

        return $address;
    }
    
    public function getBusinessLogoAttribute()
    {
        if(! $this->logo){
            return 'no logo';
        }
        return $this->logo;
    }
    
    protected $appends = [
        'business_logo'
    ];
    
    public function whatsappTemplateEvents()
    {
        return $this->hasMany('Modules\Whatsapp\Entities\WhatsappTemplateEvent','business_id','id');
    }
    
    /**
     * relationship with shipment company accounts 
     */
    public function shipmentAccounts() 
    {
        return $this->hasMany(ShipmentAccount::class,'business_id','id');
    }
    
    /**
     * relationship with shipment company
     */
    public function shipmentCompanies()
    {
        return $this->hasMany(ShipmentCompany::class,'business_id','id');
    }
    
    /**
     * scope filtters
     */
    public function scopeFillter(Builder $builder, $fillters)
    {
        $options = array_merge([
            'name' => null,
        ],$fillters);
        
        $builder->when($options['name'],function($builder, $value){
           $builder->where('name','=',$value);
        });
    }
    
    public static function boot()
    {
        parent::boot();
        static::created(function(){
            
        });
    }
}
