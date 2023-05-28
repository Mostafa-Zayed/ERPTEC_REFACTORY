<?php

namespace App\Http\Controllers;

use App\Business;
use App\BusinessLocation;

use App\Category;
use App\Brands;
use App\Address;
use App\Models\Cart;
use App\Media;
use App\Product;
use App\SellingPriceGroup;
use App\System;
use App\TaxRate;
use App\Utils\ModuleUtil;
use App\Utils\WebsiteUtil;
use App\Variation;
use App\VariationTemplate;
use DB;
use Illuminate\Http\Request;


use App\Transaction;
use App\PurchaseLine;
use App\Contact;
use App\TransactionPayment;
use App\TransactionSellLine;
use App\TransactionSellLinesPurchaseLines;
use App\VariationLocationDetails;


use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use Modules\Woocommerce\Entities\WoocommerceSyncLog;

use Modules\Woocommerce\Utils\WoocommerceUtil;

use Yajra\DataTables\Facades\DataTables;
session_start();

class WebsiteController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $woocommerceUtil;
    protected $websiteUtil;
    protected $moduleUtil;

    /**
     * Constructor
     *
     * @param WoocommerceUtil $woocommerceUtil
     * @return void
     */
    public function __construct(WoocommerceUtil $woocommerceUtil, ModuleUtil $moduleUtil,WebsiteUtil $websiteUtil )
    {
        $this->woocommerceUtil = $woocommerceUtil;
        $this->WebsiteUtil = $websiteUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
     
    
    public function indexx($id)
    {
        try {
             $location = BusinessLocation::find($id);
            $business_id = request()->session()->get('business.id');

          /*  if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
                abort(403, 'Unauthorized action.');
            }*/
           $website =  $this->WebsiteUtil->web_client($id);
            $alerts = [];
           if(!$website){
                  $alerts['connection_failed'] = 'Unable to connect with Website, Check API settings';
           }
            $tax_rates = TaxRate::where('business_id', $business_id)
                            ->get();
          $category = Category::where('business_id', $business_id)
                        ->where('category_type', 'product')
                        ->whereNull('website_cat_id')->get();  
          
                             
            $sync_category = Category::where('business_id', $business_id)
                        ->where('category_type', 'product')
                        ->where('website_cat_id','!=', null)->get();      
                        
            $woocommerce_tax_rates = ['' => __('messages.please_select')];

           

            $not_synced_cat_count = Category::where('business_id', $business_id)
                                        ->whereNull('website_cat_id')
                                        ->count();

            if (!empty($not_synced_cat_count)) {
                $alerts['not_synced_cat'] = count($category) == 1 ? __('woocommerce::lang.one_cat_not_synced_alert') : __('woocommerce::lang.cat_not_sync_alert', ['count' => count($category)]);
            }
            
              $brand = Brands::where('business_id', $business_id)
                        
                        ->whereNull('website_brand_id')
                        ->get();  
                        
            $sync_brand = Brands::where('business_id', $business_id)
                        
                       ->where('website_brand_id','!=', null)
                        ->get();  
       $not_synced_brand_count = Brands::where('business_id', $business_id)
                                        ->whereNull('website_brand_id')
                                        ->count();        
         if (!empty($not_synced_brand_count)) {
                $alerts['not_synced_brand'] = count($brand) == 1 ? __('woocommerce::lang.one_cat_not_synced_alert') : __('woocommerce::lang.cat_not_sync_alert', ['count' => count($brand)]);
            }
                
            
/*
            $cat_last_sync = $this->woocommerceUtil->getLastSync($business_id, 'categories', false);
            if (!empty($cat_last_sync)) {
                $updated_cat_count = Category::where('business_id', $business_id)
                                        ->whereNotNull('woocommerce_cat_id')
                                        ->where('updated_at', '>', $cat_last_sync)
                                        ->count();
            }
            
            if (!empty($updated_cat_count)) {
                $alerts['updated_cat'] = $updated_cat_count == 1 ? __('woocommerce::lang.one_cat_updated_alert') : __('woocommerce::lang.cat_updated_alert', ['count' => $updated_cat_count]);
            }

            $products_last_synced = $this->woocommerceUtil->getLastSync($business_id, 'all_products', false);
            $not_synced_product_count = Product::where('business_id', $business_id)
                                        ->whereIn('type', ['single', 'variable'])
                                        ->whereNull('woocommerce_product_id')
                                        ->where('woocommerce_disable_sync', 0)
                                        ->count();

            if (!empty($not_synced_product_count)) {
                $alerts['not_synced_product'] = $not_synced_product_count == 1 ? __('woocommerce::lang.one_product_not_sync_alert') : __('woocommerce::lang.product_not_sync_alert', ['count' => $not_synced_product_count]);
            }
            if (!empty($products_last_synced)) {
                $updated_product_count = Product::where('business_id', $business_id)
                                        ->whereNotNull('woocommerce_product_id')
                                        ->whereIn('type', ['single', 'variable'])
                                        ->where('updated_at', '>', $products_last_synced)
                                        ->count();
            }

            if (!empty($updated_product_count)) {
                $alerts['not_updated_product'] = $updated_product_count == 1 ? __('woocommerce::lang.one_product_updated_alert') : __('woocommerce::lang.product_updated_alert', ['count' => $updated_product_count]);
            }

            $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
            if (empty($notAllowed)) {
                $response = $this->woocommerceUtil->getTaxRates($business_id);
                if (!empty($response)) {
                    foreach ($response as $r) {
                        $woocommerce_tax_rates[$r->id] = $r->name;
                    }
                }
            }*/
        } catch (\Exception $e) {
            $alerts['connection_failed'] = 'Unable to connect with Website, Check API settings';
        }
        

        return view('website_setting.indexx')
                ->with(compact('tax_rates', 'woocommerce_tax_rates', 'alerts', 'location', 'category', 'sync_category', 'brand', 'sync_brand'));
    }

  public function conection($id)
    {
          $website =  $this->WebsiteUtil->web_client($id);
          
         return $website;
    }

      public function website_setting()
    {
      

   
            $business_id = request()->session()->get('user.business_id');

            $locations = BusinessLocation::where('business_id', $business_id)->get();

            
       

        return view('website_setting.index',compact('locations'));
    }


  public function index2()
    {
       if (!auth()->user()->can('business_settings.access')) {
            abort(403, 'Unauthorized action.');
        }

        $business_id = request()->session()->get('user.business_id');
     

        if (request()->ajax()) {
          
            $sells = BusinessLocation::where('business_locations.business_id', $business_id)
                ->select('business_locations.name as name', 'location_id', 'landmark', 'city', 'zip_code', 'state',
                    'country', 'business_locations.id', 'business_locations.is_active');

            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $sells->whereIn('business_locations.location_id', $permitted_locations);
            }

          
         
            
            $sells->groupBy('business_locations.id');

        

            $datatable = Datatables::of($sells)
                ->addColumn(
                    'action',
                  '
                    <a href="{{action(\'WebsiteController@apiSettings\', [$id])}}" class="btn btn-success btn-xs"><i class="fa fa-wrench"></i> @lang("messages.apiSettings")</a>

                    '
                )
                ->removeColumn('id')
             
              ;

            $rawColumns = [ 'action' ];
                
            return $datatable->rawColumns($rawColumns)
                      ->make(true);
        }

  

        return view('website_setting.index') ;
    }
    /**
     * Displays form to update woocommerce api settings.
     * @return Response
     */
    public function apiSettings($id)
    {
        
        $business_id = request()->session()->get('business.id');

    /*    if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module') && auth()->user()->can('woocommerce.access_woocommerce_api_settings')))) {
            abort(403, 'Unauthorized action.');
        }*/

        $default_settings = [
            'website_app_url' => '',
            'website_app_code' => '',
            'website_app_secret' => '',
            'location_id' => null,
            'default_tax_class' => '',
            'product_tax_type' => 'inc',
            'default_selling_price_group' => '',
            'product_fields_for_create' => ['category', 'quantity'],
            'product_fields_for_update' => ['name', 'price', 'category', 'quantity'],
        ];

        $price_groups = SellingPriceGroup::where('business_id', $business_id)
                        ->pluck('name', 'id')->prepend(__('lang_v1.default'), '');

        $business = BusinessLocation::find($id);

        $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            $business = null;
        }

        if (!empty($business->website_api_settings)) {
            $default_settings = json_decode($business->website_api_settings, true);
            if (empty($default_settings['product_fields_for_create'])) {
                $default_settings['product_fields_for_create'] = [];
            }

            if (empty($default_settings['product_fields_for_update'])) {
                $default_settings['product_fields_for_update'] = [];
            }
        }


        $order_url = url('/api/create/order/'.$id);
        $locations = BusinessLocation::forDropdown($business_id);
        $module_version = System::getProperty('woocommerce_version');

        $cron_job_command = $this->moduleUtil->getCronJobCommand();

        return view('website_setting.api_settings')
                ->with(compact('default_settings', 'locations', 'price_groups', 'module_version', 'cron_job_command', 'business', 'order_url'));
    }

    /**
     * Updates woocommerce api settings.
     * @return Response
     */
    public function updateSettings(Request $request,$id)
    {
        $business_id = request()->session()->get('business.id');

       

      /*  $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }*/

        try {
            $input = $request->except('_token');

            $input['website_app_url'] = !empty($request->website_app_url) ? $request->website_app_url : '';
            $input['website_app_code'] = !empty($request->website_app_code) ? $request->website_app_code : '';
            $input['website_app_secret'] = !empty($request->website_app_secret) ? $request->website_app_secret : '';

            $business = BusinessLocation::find($id);
            $business->website_api_settings = json_encode($input);
            $business->website_app_url = $input['website_app_url'];
            
           $business->website_app_code = $input['website_app_code'];
         /*   $business->woocommerce_wh_oc_secret = $input['woocommerce_wh_oc_secret'];
            $business->woocommerce_wh_ou_secret = $input['woocommerce_wh_ou_secret'];
            $business->woocommerce_wh_od_secret = $input['woocommerce_wh_od_secret'];
            $business->woocommerce_wh_or_secret = $input['woocommerce_wh_or_secret'];*/
            $business->save();

            $output = ['success' => 1,
                            'msg' => trans("lang_v1.updated_succesfully")
                        ];
        } catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                            'msg' => trans("messages.something_went_wrong")
                        ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Synchronizes pos categories with Woocommerce categories
     * @return Response
     */
     
     
    public function syncCategories(Request $request)
    {
        $business_id = request()->session()->get('business.id');
                $id = $request->location ;
        
          $website =  $this->WebsiteUtil->web_client($id);
          
        if(!$website){
            
            return  ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

     

        try {
       $cats = [];
            $user_id = request()->session()->get('user.id');
          
         $web = $this->WebsiteUtil->syncCategories($business_id, $user_id,$id);
    
          if(isset($web[0])){
            foreach($web[0] as $Cat){
          $cats =  Category::find($Cat['erp_id']);
            if($cats){
                $cats->website_cat_id = $Cat['id'] ;
                 $cats->save();
            }
        } 
            
           }
          
       /*    */

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
        }

        return $output;
    }
    
    
  public function syncedCategories(Request $request)
    {
        $business_id = request()->session()->get('business.id');
                $id = $request->location ;
        
          $website =  $this->WebsiteUtil->web_client($id);
          
        if(!$website){
            
            return  ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

     

        try {
               $cats = [];
            $user_id = request()->session()->get('user.id');
          
         $web = $this->WebsiteUtil->syncedCategories($business_id, $user_id,$id);
    
       /*    */

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
        }

        return $output;
    }



    public function syncBrands(Request $request)
    {
        $business_id = request()->session()->get('business.id');
                $id = $request->location ;
        
          $website =  $this->WebsiteUtil->web_client($id);
          
        if(!$website){
            
            return  ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

     

        try {
       $cats = [];
            $user_id = request()->session()->get('user.id');
          
         $web = $this->WebsiteUtil->syncBrands($business_id, $user_id,$id);
     
          if(isset($web[0])){
            foreach($web[0] as $Brand){
          $Brands =  Brands::find($Brand['erp_id']);
            if($Brands){
                $Brands->website_brand_id = $Brand['id'] ;
                 $Brands->save();
            }
        } 
            
           }
          
       /*    */

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
        }

        return $output;
    }
    
    
  public function syncedBrands(Request $request)
    {
        $business_id = request()->session()->get('business.id');
                $id = $request->location ;
        
          $website =  $this->WebsiteUtil->web_client($id);
          
        if(!$website){
            
            return  ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
        }

     

        try {
               $cats = [];
            $user_id = request()->session()->get('user.id');
          
         $web = $this->WebsiteUtil->syncedBrands($business_id, $user_id,$id);

       /*    */

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
        }

        return $output;
    }

    
 public function createorder(Request $request,$id)
    {
        $order =  json_decode($request->order, true);
        $code =  $request->code;
        $location = BusinessLocation::where('website_app_code', $code)->where('id',$id)->first();  
       $cart = unserialize(bzdecompress(utf8_decode($order['cart']))); 
       $cart = new Cart($cart);      
       $output = '' ;      
          if(isset($location))  {
              
           $business =   Business::find($location->business_id);
            
            
              
           /* ERP Section*/
        $subtotal = 0 ;
    
    
        
    
    
    
        $now = \Carbon::now();
     
     try {       
         
         
     DB::beginTransaction();
     
        if(isset($order['user'])){
            
            
            
  $contact = Contact::where('web_id',$order['user_id'])->first();
           
     if(!empty($contact)){ 
        if(empty($contact->landmark)){
		  	$contact->landmark = $order['customer_address'];  
		  	  $contact->city = $order['customer_city'] ;
		  	  
		  	     $contact->country = $order['customer_country'];
		  	 $contact->save();
		   }
        }
   if(empty($contact)){
            
        	$str1 = substr($order['customer_phone'], 1); 
			$contact = Contact::Where(function($query) use($order,$str1) {
                $query->where('mobile',$order['customer_phone'])->orwhere('mobile', $str1);
            })->first(); 
			
			if(!empty($contact)){
			    
		    $contact->mobile = $order['customer_phone'];
		    if(empty($contact->landmark)){
		        
		     	$contact->landmark = $order['customer_address'];  
		    }
	    	 if(empty($contact->city)){
		        
		      $contact->city = $order['customer_city'] ;
		    }

	 if(empty($contact->country)){
		        
		      $contact->country = $order['customer_country'] ;
		    }
	
            $contact->web_id = $order['user_id'];
             $contact->contact_id = $order['user']['contact_id'];
             $contact->trafic_id = 9;
             $contact->save();  
			    
			    
			}else{
			    
			$contact = new Contact();
            $contact->name = $order['customer_name'];
            $contact->mobile = $order['customer_phone'];
            $contact->email = $order['customer_email'];
            $contact->landmark = $order['customer_address'];
            $contact->country = $order['customer_country'] ;
              $contact->city = $order['customer_city'] ;
            
            $contact->type = "customer";
            $contact->business_id = $business->id;
            $contact->created_by = $business->owner_id;
            $contact->contact_id = $order['user']['contact_id'];
            $contact->web_id = $order['user_id'];
             $contact->trafic_id = 9;
            $contact->save();  
            
              $address = new Address ;
            $address->business_id = $business->id ;
            $address->contact_id = $contact->id ;
            $address->name = 'عنوان 1' ;
            $address->country = $order['customer_country'] ;
            $address->city = $order['customer_city'] ;
         
            $address->address = $order['customer_address'] ;
            $address->phone = $order['customer_phone'] ;
            $address->mobile = $order['customer_phone'] ;
             $address->save();  
            
            
			}
			
            
            
        }
        
            
        }else{
            
            	$str1 = substr($order['customer_phone'], 1); 
			$contact = Contact::Where(function($query) use($order,$str1) {
                $query->where('mobile',$order['customer_phone'])->orwhere('mobile', $str1);
            })->first(); 
		
			if(!empty($contact)){
	    
		    $contact->mobile = $order['customer_phone'];
		    if(empty($contact->landmark)){
		        
		     	$contact->landmark = $order['customer_address'];  
		    }
	    	 if(empty($contact->city)){
		        
		      $contact->city = $order['customer_city'] ;
		    }

	 if(empty($contact->country)){
		        
		      $contact->country = $order['customer_country'] ;
		    }
	
       
             $contact->save();  
			    
			    
			}else{
			 
			$contact = new Contact();
            $contact->name = $order['customer_name'];
            $contact->mobile = $order['customer_phone'];
            $contact->email = $order['customer_email'];
            $contact->landmark = $order['customer_address'];
            $contact->country = $order['customer_country'] ;
              $contact->city = $order['customer_city'] ;
            
            $contact->type = "customer";
            $contact->business_id = $business->id;
            $contact->created_by = $business->owner_id;
            $contact->contact_id = rand();
            $contact->web_id = $order['user_id'];
             $contact->trafic_id = 9;
            $contact->save();  
            
              $address = new Address ;
            $address->business_id = $business->id ;
            $address->contact_id = $contact->id ;
            $address->name = 'عنوان 1' ;
            $address->country = $order['customer_country'] ;
            $address->city = $order['customer_city'] ;
         
            $address->address = $order['customer_address'] ;
            $address->phone = $order['customer_phone'] ;
            $address->mobile = $order['customer_phone'] ;
             $address->save();  
            
            
			}  
            
            
        //  $contact = Contact::where('is_default',1)->where('business_id',$business->id)->first();
            
            
        }
        
      
          

      /** $order['currency_value']*/

        $transaction = new Transaction();
        $transaction->business_id = $business->id ;
        $transaction->location_id = $location->id ;
        $transaction->type = "sell" ;
        $transaction->status = "final";
        $transaction->essentials_duration = 0.00;
        $transaction->payment_status = $order['payment_status'] != 'Pending' ? "paid"  : "due";
        $transaction->invoice_no = $order['order_number'];
        $transaction->contact_id =  $contact->id ;
        $transaction->transaction_date = $now;
        $transaction->shipping_status = "pending";
        $transaction->order_status = "pending";
        $transaction->shipping_charges = $order['shipping_price'];
        $transaction->shipping_phone = $order['customer_phone'];
        $transaction->shipping_name = $order['customer_name'];
        $transaction->total_before_tax = 0 ;
        $transaction->trafic_id = 9 ;
        $transaction->shipping_address = !empty($order['customer_address']) ? $order['customer_address'] : $contact->landmark;
        $transaction->shipping_details = isset($order['shipment']) ? $order['shipment']['name'] : null;
        $transaction->shipment_id = null;
        $transaction->additional_notes = $order['order_note'];
        $transaction->final_total = $order['pay_amount'] ;
        $transaction->created_by = $business->owner_id;
        $transaction->packing_charge = $order['packing_cost'];
        $transaction->recur_interval_type = "days";
        $transaction->website_order_id = $order['id'];
        $transaction->save();
        
        if($order['payment_status'] != 'Pending'){
        $transaction_payments = new TransactionPayment ;
        $transaction_payments->transaction_id = $transaction->id ;
        $transaction_payments->business_id = $business->id ;
        $transaction_payments->amount = $transaction->final_total;
        $transaction_payments->method = "custom_pay_1";
        $transaction_payments->transaction_no = $order['order_number'];
        $transaction_payments->card_type = "credit";
        $transaction_payments->paid_on = $now;
        $transaction_payments->created_by = $business->owner_id;
        $transaction_payments->payment_for = !empty($contact) ? $contact->id : null;
        $transaction_payments->note = $order['order_note'];
        $transaction_payments->payment_ref_no = $transaction->id;
        $transaction_payments->save();
        }
       /* 
        */
    
     /** $order['currency_value']*/
     foreach($cart->items as $prod)
        {
         $subtotal += $prod['price'] ;
         $p =  Product::find($prod['item']['erp_id']);
         
          if($prod['item']['price'] == 0){
             $price = $prod['size_price'];
         }else{
              $price = $prod['item']['price'];
             
         }  
         
         if(!empty($p)){
           
         
         
            if(!empty($prod['var'])){
               $variation = Variation::where('id',$prod['var'])->first();
             }else{
               $variation = Variation::where('product_id',$p->id)->first();   
             }
             
           $purchaseLine = PurchaseLine::where('variation_id',$variation->id)->whereRaw('(quantity_sold + quantity_adjusted + quantity_returned) < quantity')->orderby('id','DESC')->first();
            if(!empty($purchaseLine)){
            $purchaseLine->quantity_sold += $prod['qty'] ;
            $purchaseLine->save() ;
            }   /** $order['currency_value']*/
            $transaction_sell_lines = new TransactionSellLine ;
            $transaction_sell_lines->transaction_id = $transaction->id ;
            $transaction_sell_lines->product_id = $p->id ;
            $transaction_sell_lines->variation_id = $variation->id ;
            $transaction_sell_lines->item_tax = 0 ;
            $transaction_sell_lines->quantity = $prod['qty'] ;
            $transaction_sell_lines->unit_price_before_discount = $price  ;
            $transaction_sell_lines->unit_price = $price  ;
            $transaction_sell_lines->unit_price_inc_tax = $price  ;
            $transaction_sell_lines->line_discount_type = "fixed";
            $transaction_sell_lines->lot_no_line_id = !empty($purchaseLine) ? $purchaseLine->id : null ;
            $transaction_sell_lines->save();
            
            $transaction_sell_lines_purchase_lines = new TransactionSellLinesPurchaseLines ;
            $transaction_sell_lines_purchase_lines->sell_line_id = $transaction_sell_lines->id ;
            
      
            
            $VariationLocationDetails = VariationLocationDetails::where('variation_id',$variation->id)->first();
           
            
            if(!empty($VariationLocationDetails)){
            $VariationLocationDetails->qty_available -= $prod['qty'] ;
            $VariationLocationDetails->save() ;
            }
            $transaction_sell_lines_purchase_lines->purchase_line_id = !empty($purchaseLine) ? $purchaseLine->id : null ;
            $transaction_sell_lines_purchase_lines->quantity = $prod['qty'] ;
            $transaction_sell_lines_purchase_lines->save() ;
         }
            
        }
     $transactio = Transaction::find($transaction->id);
     $transactio->total_before_tax  =  $subtotal ;  
     $transactio->save();
     
        /* End ERP Section */ 
             DB::commit();
            $output = ['success' => true,
                            'msg' => trans("lang_v1.updated_succesfully")
                        ];
        } catch (\Exception $e) {
             DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => $e->getMessage(),
                            'msg' => trans("messages.something_went_wrong")
                        ];
        }
   
              
      }
        
         return response()->json($output);  
        
    }





   /*################################################ For Delete ##########################################################33*/



    /**
     * Synchronizes pos products with Woocommerce products
     * @return Response
     */
     
     
     
    public function syncProducts()
    {
        $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module') && auth()->user()->can('woocommerce.sync_products')))) {
            abort(403, 'Unauthorized action.');
        }

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        try {
            $user_id = request()->session()->get('user.id');
            $sync_type = request()->input('type');

            DB::beginTransaction();

            $this->woocommerceUtil->syncProducts($business_id, $user_id, $sync_type);
            
            DB::commit();

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }
        }
        
        return $output;
    }

    /**
     * Synchronizes Woocommers Orders with POS sales
     * @return Response
     */
    public function syncOrders()
    {
        $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module') && auth()->user()->can('woocommerce.sync_orders')))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $user_id = request()->session()->get('user.id');
           
            $this->woocommerceUtil->syncOrders($business_id, $user_id);

            DB::commit();

            $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\Woocommerce\Exceptions\WooCommerceError') {
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
            } else {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong"),
                        ];
            }
        }

        return $output;
    }

    /**
     * Retrives sync log
     * @return Response
     */
    public function getSyncLog()
    {
        $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $last_sync = [
                'categories' => $this->woocommerceUtil->getLastSync($business_id, 'categories'),
                'new_products' => $this->woocommerceUtil->getLastSync($business_id, 'new_products'),
                'all_products' => $this->woocommerceUtil->getLastSync($business_id, 'all_products'),
                'orders' => $this->woocommerceUtil->getLastSync($business_id, 'orders')

            ];
            return $last_sync;
        }
    }

    /**
     * Maps POS tax_rates with Woocommerce tax rates.
     * @return Response
     */
    public function mapTaxRates(Request $request)
    {
        $notAllowed = $this->woocommerceUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module') && auth()->user()->can('woocommerce.map_tax_rates')))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->except('_token');
            foreach ($input['taxes'] as $key => $value) {
                $value = !empty($value) ? $value : null;
                TaxRate::where('business_id', $business_id)
                        ->where('id', $key)
                        ->update(['woocommerce_tax_rate_id' => $value]);
            }

            $output = ['success' => 1,
                            'msg' => __("lang_v1.updated_succesfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

            $output = ['success' => 0,
                        'msg' => __("messages.something_went_wrong"),
                    ];
        }

        return redirect()->back()->with(['status' => $output]);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function viewSyncLog()
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $logs = WoocommerceSyncLog::where('woocommerce_sync_logs.business_id', $business_id)
                    ->leftjoin('users as U', 'U.id', '=', 'woocommerce_sync_logs.created_by')
                    ->select([
                        'woocommerce_sync_logs.created_at',
                        'sync_type', 'operation_type',
                        DB::raw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) as full_name"),
                        'woocommerce_sync_logs.data',
                        'woocommerce_sync_logs.details as log_details',
                        'woocommerce_sync_logs.id as DT_RowId'
                    ]);
            $sync_type = [];
            if (auth()->user()->can('woocommerce.syc_categories')) {
                $sync_type[] = 'categories';
            }
            if (auth()->user()->can('woocommerce.sync_products')) {
                $sync_type[] = 'all_products';
                $sync_type[] = 'new_products';
            }

            if (auth()->user()->can('woocommerce.sync_orders')) {
                $sync_type[] = 'orders';
            }
            if (!auth()->user()->can('superadmin')) {
                $logs->whereIn('sync_type', $sync_type);
            }

            return Datatables::of($logs)
                ->editColumn('created_at', function ($row) {
                    $created_at = $this->woocommerceUtil->format_date($row->created_at, true);
                    $for_humans = \Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->diffForHumans();
                    return $created_at . '<br><small>' . $for_humans . '</small>';
                })
                ->editColumn('sync_type', function ($row) {
                    $array = [
                        'categories' => __('category.categories'),
                        'all_products' => __('sale.products'),
                        'new_products' => __('sale.products'),
                        'orders' => __('woocommerce::lang.orders'),
                    ];
                    return $array[$row->sync_type];
                })
                ->editColumn('operation_type', function ($row) {
                    $array = [
                        'created' => __('woocommerce::lang.created'),
                        'updated' => __('woocommerce::lang.updated'),
                        'reset' => __('woocommerce::lang.reset'),
                    ];
                    return array_key_exists($row->operation_type, $array) ? $array[$row->operation_type] : '';
                })
                ->editColumn('data', function ($row) {
                    if (!empty($row->data)) {
                        $data = json_decode($row->data, true);
                        return implode(', ', $data) . '<br><small>' . count($data) . ' ' . __('woocommerce::lang.records') . '</small>';
                    } else {
                        return '';
                    }
                })
                ->editColumn('log_details', function ($row) {
                    $details = '';
                    if (!empty($row->log_details)) {
                        $details = $row->log_details;
                    }
                    return $details;
                })
                ->filterColumn('full_name', function ($query, $keyword) {
                    $query->whereRaw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) like ?", ["%{$keyword}%"]);
                })
                ->rawColumns(['created_at', 'data'])
                ->make(true);
        }

        return view('website_setting.sync_log');
    }

    /**
     * Retrives details of a sync log.
     * @param int $id
     * @return Response
     */
    public function getLogDetails($id)
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $log = WoocommerceSyncLog::where('business_id', $business_id)
                                            ->find($id);
            $log_details = json_decode($log->details);
            
            return view('website_setting.partials.log_details')
                    ->with(compact('log_details'));
        }
    }

    /**
     * Resets synced categories
     * @return json
     */
    public function resetCategories()
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                Category::where('business_id', $business_id)
                        ->update(['woocommerce_cat_id' => null]);
                $user_id = request()->session()->get('user.id');
                $this->woocommerceUtil->createSyncLog($business_id, $user_id, 'categories', 'reset', null);

                $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.cat_reset_success"),
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => __("messages.something_went_wrong"),
                        ];
            }

            return $output;
        }
    }

    /**
     * Resets synced products
     * @return json
     */
    public function resetProducts()
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'woocommerce_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                //Update products table
                Product::where('business_id', $business_id)
                        ->update(['woocommerce_product_id' => null, 'woocommerce_media_id' => null]);

                $product_ids = Product::where('business_id', $business_id)
                                    ->pluck('id');

                $product_ids = !empty($product_ids) ? $product_ids : [];
                //Update variations table
                Variation::whereIn('product_id', $product_ids)
                        ->update([
                            'woocommerce_variation_id' => null
                        ]);

                //Update variation templates
                VariationTemplate::where('business_id', $business_id)
                                ->update([
                                    'woocommerce_attr_id' => null
                                ]);

                Media::where('business_id', $business_id)
                        ->update(['woocommerce_media_id' => null]);

                $user_id = request()->session()->get('user.id');
                $this->woocommerceUtil->createSyncLog($business_id, $user_id, 'all_products', 'reset', null);

                $output = ['success' => 1,
                            'msg' => __("woocommerce::lang.prod_reset_success"),
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());

                $output = ['success' => 0,
                            'msg' => "File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage(),
                        ];
            }

            return $output;
        }
    }
}
