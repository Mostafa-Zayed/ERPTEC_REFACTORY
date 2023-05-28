<?php

namespace App\Http\Traits;

use Illuminate\Http\Request;
use App\Utils\DropDowns\UnitDropDown;
use Illuminate\Support\Facades\Schema;
use App\User;
use App\ReferenceCount;
use App\Contact;
use App\InvoiceScheme;
use App\InvoiceLayout;
use App\Unit;
use App\NotificationTemplate;
use App\Business;
use App\BusinessLocation;

trait BusinessService
{
    public static function getBusinessId()
    {
        return request()->session()->get('user.business_id');
    }
    
    public static function businessCan($permissions)
    {
        foreach ($permissions as $permission) {
            if (!auth()->user()->can($permission)) {
                abort(403, 'Unauthorized action.');
            }
        }
        
        return true;
    }
    
    public static function defaultProfitPercent()
    {
        return request()->session()->get('business.default_profit_percent');
    }
    
    public static function getUser()
    {
        return request()->session()->get('user.id');
    }
    
    public function checkRequest(Request & $request,$key,$value = null ,$returnValue = null)
    {
        if ($request->filled($key)){
            
            return $request->$key;
            
        } elseif($request->filled($key) && ! is_null($value)) {
            
            return $request->$key == $value ? $request->$key : false;
            
        } elseif($request->filled($key) && ! is_null($value) && ! is_null($returnValue)) {
            
            return $returnValue;
        }
    }
    
    public static function getSessionValue($key,$type = 'user')
    {
        return request()->session()->get($type . '.' . $key);
    }
    
    public static function getDrowpDown($model,$options = [])
    {
        switch($model){
            case 'unit':
                return (new UnitDropDown())->drawMenu();
            break;    
        }
    }
    
    public static function businessCanRegister()
    {
        return config('business.allowRegistration') ? true : false;
    }
    
    public static function searchWithColumnValue($columnName, $value)
    {
        if(self::ifTableColumnExists($columnName)) {
            // if($count = User::where('username', $username)->count() > 0)
            return User::where($columnName, $username)->count() > 0 ? true : false;
        }
    }
    
    public static function ifTableColumnExists(& $columnName, $connection = 'mysql')
    {
        return Schema::connection("mysql")->hasColumn('business',$columnName) ?? false;
    }
    
    public static function getCommissionAgentDropdown()
    {
        return [
            '' => __('lang_v1.disable'),
            'logged_in_user' => __('lang_v1.logged_in_user'),
            'user' => __('lang_v1.select_from_users_list'),
            'cmsn_agnt' => __('lang_v1.select_from_commisssion_agents_list')
        ];
    }
    
    /**
     * Increments reference count for a given type and given business
     * and gives the updated reference count
     *
     * @param string $type
     * @param int $business_id
     *
     * @return int
     */
    public static function setAndGetReferenceCount($type, $businessId = null)
    {
        $businessId = empty($businessId) ? self::getBusinessId(): $businessId;

        $ref = ReferenceCount::where('ref_type', $type)->where('business_id', $businessId)->first();
        
        return $ref;
        if (!empty($ref)) {
            $ref->ref_count += 1;
            $ref->save();
            return $ref->ref_count;
        } else {
            $new_ref = ReferenceCount::create([
                'ref_type' => $type,
                'business_id' => $business_id,
                'ref_count' => 1
            ]);
            return $new_ref->ref_count;
        }
    }
    
    public static function incrementReferenceCountWith($type, $businessId = null, $counter = 1)
    {
        $businessId = empty($businessId) ? self::getBusinessId(): $businessId;
        
        $businessReference = ReferenceCount::where('ref_type', $type)->where('business_id', $businessId)->first();
        
        if(! empty($businessReference)){
            $businessReference->ref_count += $counter;
            $businessReference->save();
            return $businessReference->ref_count;
        }
        
        return ReferenceCount::create(['ref_type' => $type,'business_id' => $businessId, 'ref_count' => $counter])->ref_count;
        
    }
    public static function createDefaultCustomer($businessId, $contactId, $userId)
    {
        Contact::create([
            'business_id' => $businessId,
            'type' => 'customer',
            'name' => 'Walk-In Customer',
            'created_by' => $userId,
            'is_default' => 1,
            'contact_id' => $contactId,
            'credit_limit' => 0
        ]);
    }
    
    public static function createDefaultInvoiceScheme($businessId)
    {
        InvoiceScheme::create([
            'name' => 'Default',
            'scheme_type' => 'blank',
            'prefix' => '',
            'start_number' => 1,
            'total_digits' => 4,
            'is_default' => 1,
            'business_id' => $businessId
        ]);
    }
    
    public static function createDefaultInvoiceLayout($businessId)
    {
        InvoiceLayout::create([
            'name' => 'Default',
            'header_text' => null,
            'invoice_no_prefix' => 'Invoice No.',
            'invoice_heading' => 'Invoice',
            'sub_total_label' => 'Subtotal',
            'discount_label' => 'Discount',
            'tax_label' => 'Tax',
            'total_label' => 'Total',
            'show_landmark' => 1,
            'show_city' => 1,
            'show_state' => 1,
            'show_zip_code' => 1,
            'show_country' => 1,
            'highlight_color' => '#000000',
            'footer_text' => '',
            'is_default' => 1,
            'business_id' => $businessId,
            'invoice_heading_not_paid' => '',
            'invoice_heading_paid' => '',
            'total_due_label' => 'Total Due',
            'paid_label' => 'Total Paid',
            'show_payments' => 1,
            'show_customer' => 1,
            'customer_label' => 'Customer',
            'table_product_label' => 'Product',
            'table_qty_label' => 'Quantity',
            'table_unit_price_label' => 'Unit Price',
            'table_subtotal_label' => 'Subtotal',
            'date_label' => 'Date'
        ]);
    }
    
    public static function createDefaultUnit($businessId, $userId)
    {
        Unit::create([
            'business_id' => $businessId,
            'actual_name' => 'Pieces',
            'short_name' => 'Pc(s)',
            'allow_decimal' => 0,
            'created_by' => $userId
        ]);
    }
    
    public static function createDefaultNotificationTemplates($businessId)
    {
        foreach(self::getDefaultNotificationTemplates($businessId) as $template) {
            NotificationTemplate::create($template);
        }
    }
    
    public static function getDefaultNotificationTemplates($businessId)
    {
        return [
            [
                'business_id' => $businessId,
                'template_for' => 'new_sale',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>Your invoice number is {invoice_number}<br />
                    Total amount: {total_amount}<br />
                    Paid amount: {received_amount}</p>

                    <p>Thank you for shopping with us.</p>

                    <p>{business_logo}</p>

                    <p>&nbsp;</p>',
                'sms_body' => 'Dear {contact_name}, Thank you for shopping with us. {business_name}',
                'subject' => 'Thank you from {business_name}',
                'auto_send' => '0'
            ],

            [
                'business_id' => $businessId,
                'template_for' => 'payment_received',
                'email_body' => '<p>Dear {contact_name},</p>

                <p>We have received a payment of {received_amount}</p>

                <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, We have received a payment of {received_amount}. {business_name}',
                'subject' => 'Payment Received, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'payment_reminder',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>This is to remind you that you have pending payment of {due_amount}. Kindly pay it as soon as possible.</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, You have pending payment of {due_amount}. Kindly pay it as soon as possible. {business_name}',
                'subject' => 'Payment Reminder, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'new_booking',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>Your booking is confirmed</p>

                    <p>Date: {start_time} to {end_time}</p>

                    <p>Table: {table}</p>

                    <p>Location: {location}</p>

                    <p>{business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, Your booking is confirmed. Date: {start_time} to {end_time}, Table: {table}, Location: {location}','subject' => 'Booking Confirmed - {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'new_order',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have a new order with reference number {order_ref_number}. Kindly process the products as soon as possible.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'Dear {contact_name}, We have a new order with reference number {order_ref_number}. Kindly process the products as soon as possible. {business_name}',
                'subject' => 'New Order, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'payment_paid',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have paid amount {paid_amount} again invoice number {order_ref_number}.<br />
                    Kindly note it down.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'We have paid amount {paid_amount} again invoice number {order_ref_number}.
                    Kindly note it down. {business_name}',
                'subject' => 'Payment Paid, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'items_received',
                'email_body' => '<p>Dear {contact_name},</p>

                    <p>We have received all items from invoice reference number {order_ref_number}. Thank you for processing it.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'We have received all items from invoice reference number {order_ref_number}. Thank you for processing it. {business_name}',
                'subject' => 'Items received, from {business_name}',
                'auto_send' => '0'
            ],
            [
                'business_id' => $businessId,
                'template_for' => 'items_pending',
                'email_body' => '<p>Dear {contact_name},<br />
                    This is to remind you that we have not yet received some items from invoice reference number {order_ref_number}. Please process it as soon as possible.</p>

                    <p>{business_name}<br />
                    {business_logo}</p>',
                'sms_body' => 'This is to remind you that we have not yet received some items from invoice reference number {order_ref_number} . Please process it as soon as possible.{business_name}',
                'subject' => 'Items Pending, from {business_name}',
                'auto_send' => '0'
            ]
        ];
    }
    
    public static function generateReferenceNumber($type, $referenceCount, $businessId = null, $defaultPrefix = null)
    {
        $prefix = session()->has('business') && ! empty(self::getSessionValue('ref_no_prefixes','business')[$type]) ? self::getSessionValue('ref_no_prefixes','business') : null;
        
        $prefix = ! empty($businessId) ? Business::find($businessId)->ref_no_prefixes[$type] : null;
        
        $prefix = ! empty($defaultPrefix) ? $defaultPrefix : null;
        
        $referenceDigits =  str_pad($referenceCount, 4, 0, STR_PAD_LEFT);
        
        if(! in_array($type,config('business.ref_count_model'))) {
            
            $referenceYear = \Carbon::now()->year;
            
            return $prefix . $referenceYear . '/' . $referenceDigits;
        } else {
            return $ref_number = $prefix . $referenceDigits;
        }
    }
    
    /**
     * Adds a new location to a business
     *
     * @param int $business_id
     * @param array $location_details
     * @param int $invoice_layout_id default null
     *
     * @return location object
     */
    public static function addLocation($businessId, $locationDetails, $invoiceSchemeId = null, $invoiceLayoutId = null)
    {
        $invoiceLayoutId = empty($invoiceSchemeId) ? InvoiceLayout::where('is_default', 1)->where('business_id', $businessId)->first()->id : null;
        
        $invoiceSchemeId = empty($invoiceSchemeId) ? InvoiceLayout::where('is_default', 1)->where('business_id', $businessId)->first()->id: null;
        
        // create or update reference counte 
        $locationsRefNumber = BusinessService::incrementReferenceCountWith('business_location',$businessId);
        
        $locationId = BusinessService::generateReferenceNumber('business_location',$locationsRefNumber,$businessId);
        
        //Enable all payment methods by default
        $payment_types = slef::allPaymentTypes();
        
        $location_payment_types = [];
        
        foreach ($payment_types as $key => $value) {
            
            $location_payment_types[$key] = [
                'is_enabled' => 1,
                'account' => null
            ];
        }
        
        return BusinessLocation::create([
            'business_id' => $businessId,
            'name' => $locationDetails['name'],
            'landmark' => $locationDetails['landmark'],
            'city' => $locationDetails['city'],
            'state' => $locationDetails['state'],
            'zip_code' => $locationDetails['zip_code'],
            'country' => $locationDetails['country'],
            'invoice_scheme_id' => $invoiceSchemeId,
            'invoice_layout_id' => $invoice_layout_id,
            'sale_invoice_layout_id' => $invoiceLayoutId,
            'mobile' => !empty($locationDetails['mobile']) ? $locationDetails['mobile'] : '',
            'alternate_number' => !empty($locationDetails['alternate_number']) ? $locationDetails['alternate_number'] : '',
            'website' => !empty($locationDetails['website']) ? $locationDetails['website'] : '',
            'email' => '',
            'location_id' => $locationId,
            'default_payment_accounts' => json_encode($location_payment_types)
        ]);
        
        return $location;
    }
    
    /**
     * Defines available Payment Types
     *
     * @param $location mixed
     * @return array
     */
    public static function allPaymentTypes($location = null, $show_advance = false, $business_id = null)
    {
        $custom_labels = [];
        
        if(! empty($location)){
            
            $location = is_object($location) ? $location : BusinessLocation::find($location);

            $custom_labels = json_decode(Business::find($location->business_id)->custom_labels, true);
            
        } else {
            
            if (! empty($business_id)) {
                
                $custom_labels = json_decode(Business::find($business_id)->custom_labels, true);
                
            }
        }
        
        
        $paymentTypes = self::getDefaultpaymentTypes($custom_labels);
        
        if (!empty($location)) {
            $location_account_settings = !empty($location->default_payment_accounts) ? json_decode($location->default_payment_accounts, true) : [];
            
            $enabled_accounts = [];
            
            foreach ($location_account_settings as $key => $value) {
                if (!empty($value['is_enabled'])) {
                    $enabled_accounts[] = $key;
                }
            }
            
            foreach ($paymentTypes as $key => $value) {
                if (!in_array($key, $enabled_accounts)) {
                    unset($paymentTypes[$key]);
                }
            }
        }
        
        if ($show_advance) {
          $paymentTypes = ['advance' => __('lang_v1.advance')] + $paymentTypes;
        }
        
        return $paymentTypes;
        
    }
    public static function getDefaultpaymentTypes($custom_labels)
    {
        $payment_types =  [
            'cash' => __('lang_v1.cash'),
            'card' => __('lang_v1.card'),
            'cheque' => __('lang_v1.cheque'),
            'bank_transfer' => __('lang_v1.bank_transfer'),
            'other' => __('lang_v1.other')
        ];
        
        $payment_types['custom_pay_1'] = !empty($custom_labels['payments']['custom_pay_1']) ? $custom_labels['payments']['custom_pay_1'] : __('lang_v1.custom_payment', ['number' => 1]);
        $payment_types['custom_pay_2'] = !empty($custom_labels['payments']['custom_pay_2']) ? $custom_labels['payments']['custom_pay_2'] : __('lang_v1.custom_payment', ['number' => 2]);
        $payment_types['custom_pay_3'] = !empty($custom_labels['payments']['custom_pay_3']) ? $custom_labels['payments']['custom_pay_3'] : __('lang_v1.custom_payment', ['number' => 3]);
        $payment_types['custom_pay_4'] = !empty($custom_labels['payments']['custom_pay_4']) ? $custom_labels['payments']['custom_pay_4'] : __('lang_v1.custom_payment', ['number' => 4]);
        $payment_types['custom_pay_5'] = !empty($custom_labels['payments']['custom_pay_5']) ? $custom_labels['payments']['custom_pay_5'] : __('lang_v1.custom_payment', ['number' => 5]);
        $payment_types['custom_pay_6'] = !empty($custom_labels['payments']['custom_pay_6']) ? $custom_labels['payments']['custom_pay_6'] : __('lang_v1.custom_payment', ['number' => 6]);
        $payment_types['custom_pay_7'] = !empty($custom_labels['payments']['custom_pay_7']) ? $custom_labels['payments']['custom_pay_7'] : __('lang_v1.custom_payment', ['number' => 7]);
        
        return $payment_types;
    }
}