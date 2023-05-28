<?php

namespace Modules\Affilate\Http\Controllers;

use App\Business;
use App\BusinessLocation;
use App\Category;
use App\Media;
use App\Product;
use App\SellingPriceGroup;
use App\System;
use App\User;
use App\Contact;
use App\Models\Shipment;
use App\TaxRate;
use App\Utils\ModuleUtil;
use App\Variation;
use App\Transaction;
use App\VariationTemplate;
use DB;
use Illuminate\Http\Request;

use Illuminate\Http\Response;

use Illuminate\Routing\Controller;
use Modules\Affilate\Entities\AffilateSyncLog;
use Modules\Affilate\Entities\AffilatePaid;
use Modules\Affilate\Entities\AffilateCommission;

use Modules\Affilate\Utils\AffilateUtil;
use App\Utils\BusinessUtil;
use App\Utils\TransactionUtil;
use Yajra\DataTables\Facades\DataTables;

class AffilateController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $affilateUtil;
    protected $moduleUtil;
 protected $transactionUtil;
  protected $businessUtil;
    /**
     * Constructor
     *
     * @param affilateUtil $affilateUtil
     * @return void
     */
    public function __construct(AffilateUtil $affilateUtil,BusinessUtil $businessUtil,TransactionUtil $transactionUtil,  ModuleUtil $moduleUtil)
    {
         $this->businessUtil = $businessUtil;
               $this->transactionUtil = $transactionUtil;
        $this->affilateUtil = $affilateUtil;
        $this->moduleUtil = $moduleUtil;
        
                $this->shipping_status_colors = [
            'pending' => 'bg-yellow',
            'pickup' => 'bg-info',
            'storage' => 'bg-navy',
            'postponement' => 'bg-blue',
            'Ready_To_Pickup' => 'bg-light-green',
            'delivered' => 'bg-green',
            'need_action' => 'bg-navy',
            'cancelled' => 'bg-red',
            'Returned' => 'bg-red'
        ]; 
        
        $this->order_status_colors = [
            'pending' => 'bg-yellow',
            'no answer' => 'bg-info',
            'follow Up' => 'bg-navy',
            'order done' => 'bg-green',
            'canceled' => 'bg-red',
            'on_returning' => 'bg-red'
        ];
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        try {
            $business_id = request()->session()->get('business.id');

            if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
                abort(403, 'Unauthorized action.');
            }
                
      
         $business = Business::find($business_id);
         
         
         
         
        } catch (\Exception $e) {
            $alerts['connection_failed'] = 'Unable to connect with affilate, Check API settings';
        }
        

        return view('affilate::affilate.index')
                ->with(compact('business'));
    }

    /**
     * Displays form to update affilate api settings.
     * @return Response
     */
    public function apiSettings()
    {
        $business_id = request()->session()->get('business.id');

        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.access_affilate_api_settings')))) {
            abort(403, 'Unauthorized action.');
        }

        $default_settings = [
            'affilate_app_url' => '',
            'affilate_consumer_key' => '',
            'affilate_consumer_secret' => '',
            'location_id' => null,
            'default_tax_class' => '',
            'product_tax_type' => 'inc',
            'default_selling_price_group' => '',
            'product_fields_for_create' => ['category', 'quantity'],
            'product_fields_for_update' => ['name', 'price', 'category', 'quantity'],
        ];

        $price_groups = SellingPriceGroup::where('business_id', $business_id)
                        ->pluck('name', 'id')->prepend(__('lang_v1.default'), '');

        $business = Business::find($business_id);

        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            $business = null;
        }

        if (!empty($business->affilate_api_settings)) {
            $default_settings = json_decode($business->affilate_api_settings, true);
            if (empty($default_settings['product_fields_for_create'])) {
                $default_settings['product_fields_for_create'] = [];
            }

            if (empty($default_settings['product_fields_for_update'])) {
                $default_settings['product_fields_for_update'] = [];
            }
        }

        $locations = BusinessLocation::forDropdown($business_id);
        $module_version = System::getProperty('affilate_version');

        $cron_job_command = $this->moduleUtil->getCronJobCommand();

        $shipping_statuses = $this->moduleUtil->shipping_statuses();

        return view('affilate::affilate.api_settings')
                ->with(compact('default_settings', 'locations', 'price_groups', 'module_version', 'cron_job_command', 'business', 'shipping_statuses'));
    }

    /**
     * Updates affilate api settings.
     * @return Response
     */
    public function updateSettings(Request $request)
    {
        $business_id = request()->session()->get('business.id');

        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.access_affilate_api_settings')))) {
            abort(403, 'Unauthorized action.');
        }

        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        try {
            $input = $request->except('_token');

            $input['product_fields_for_create'] = !empty($input['product_fields_for_create']) ? $input['product_fields_for_create'] : [];
            $input['product_fields_for_update'] = !empty($input['product_fields_for_update']) ? $input['product_fields_for_update'] : [];
            $input['order_statuses'] = !empty($input['order_statuses']) ? $input['order_statuses'] : [];
            $input['shipping_statuses'] = !empty($input['shipping_statuses']) ? $input['shipping_statuses'] : [];

            $business = Business::find($business_id);
            $business->affilate_api_settings = json_encode($input);
            $business->affilate_wh_oc_secret = $input['affilate_wh_oc_secret'];
            $business->affilate_wh_ou_secret = $input['affilate_wh_ou_secret'];
            $business->affilate_wh_od_secret = $input['affilate_wh_od_secret'];
            $business->affilate_wh_or_secret = $input['affilate_wh_or_secret'];
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
     * Synchronizes pos categories with affilate categories
     * @return Response
     */
    public function syncCategories()
    {
        $business_id = request()->session()->get('business.id');

        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.syc_categories')))) {
            abort(403, 'Unauthorized action.');
        }

        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        try {
            DB::beginTransaction();
            $user_id = request()->session()->get('user.id');
            
            $this->affilateUtil->syncCategories($business_id, $user_id);

            DB::commit();

            $output = ['success' => 1,
                            'msg' =>__("affilate::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\affilate\Exceptions\affilateError') {
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
     * Synchronizes pos products with affilate products
     * @return Response
     */
    public function syncProducts()
    {
        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.sync_products')))) {
            abort(403, 'Unauthorized action.');
        }

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        try {
            $user_id = request()->session()->get('user.id');
            $sync_type = request()->input('type');

            DB::beginTransaction();

            $offset = request()->input('offset');
            $limit = 100;
            $all_products = $this->affilateUtil->syncProducts($business_id, $user_id, $sync_type, $limit, $offset);
            $total_products = count($all_products);
            
            DB::commit();
            $msg = $total_products > 0 ?  __("affilate::lang.n_products_synced_successfully", ['count' => $total_products]) :  __("affilate::lang.synced_successfully");
            $output = ['success' => 1,
                            'msg' => $msg,
                            'total_products' => $total_products
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\affilate\Exceptions\affilateError') {
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
        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.sync_orders')))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            DB::beginTransaction();
            $user_id = request()->session()->get('user.id');
           
            $this->affilateUtil->syncOrders($business_id, $user_id);

            DB::commit();

            $output = ['success' => 1,
                            'msg' => __("affilate::lang.synced_successfully")
                        ];
        } catch (\Exception $e) {
            DB::rollBack();

            if (get_class($e) == 'Modules\affilate\Exceptions\affilateError') {
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
        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $last_sync = [
                'categories' => $this->affilateUtil->getLastSync($business_id, 'categories'),
                'new_products' => $this->affilateUtil->getLastSync($business_id, 'new_products'),
                'all_products' => $this->affilateUtil->getLastSync($business_id, 'all_products'),
                'orders' => $this->affilateUtil->getLastSync($business_id, 'orders')

            ];
            return $last_sync;
        }
    }

    /**
     * Maps POS tax_rates with affilate tax rates.
     * @return Response
     */
    public function mapTaxRates(Request $request)
    {
        $notAllowed = $this->affilateUtil->notAllowedInDemo();
        if (!empty($notAllowed)) {
            return $notAllowed;
        }

        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || ($this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module') && auth()->user()->can('affilate.map_tax_rates')))) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $input = $request->except('_token');
            foreach ($input['taxes'] as $key => $value) {
                $value = !empty($value) ? $value : null;
                TaxRate::where('business_id', $business_id)
                        ->where('id', $key)
                        ->update(['affilate_tax_rate_id' => $value]);
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
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $logs = affilateSyncLog::where('affilate_sync_logs.business_id', $business_id)
                    ->leftjoin('users as U', 'U.id', '=', 'affilate_sync_logs.created_by')
                    ->select([
                        'affilate_sync_logs.created_at',
                        'sync_type', 'operation_type',
                        DB::raw("CONCAT(COALESCE(surname, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) as full_name"),
                        'affilate_sync_logs.data',
                        'affilate_sync_logs.details as log_details',
                        'affilate_sync_logs.id as DT_RowId'
                    ]);
            $sync_type = [];
      /*      if (auth()->user()->can('affilate.syc_categories')) {
                $sync_type[] = 'categories';
            }
            if (auth()->user()->can('affilate.sync_products')) {
                $sync_type[] = 'all_products';
                $sync_type[] = 'new_products';
            }

            if (auth()->user()->can('affilate.sync_orders')) {
                $sync_type[] = 'orders';
            }
            if (!auth()->user()->can('superadmin')) {
                $logs->whereIn('sync_type', $sync_type);
            }*/

            return Datatables::of($logs)
                ->editColumn('created_at', function ($row) {
                    $created_at = $this->affilateUtil->format_date($row->created_at, true);
                    $for_humans = \Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->diffForHumans();
                    return $created_at . '<br><small>' . $for_humans . '</small>';
                })
                ->editColumn('sync_type', function ($row) {
                    $array = [
                        'users' => __('lang_v1.users'),
                        'all_products' => __('sale.products'),
                        'new_products' => __('sale.products'),
                        'orders' => __('affilate::lang.orders'),
                    ];
                    return $array[$row->sync_type];
                })
                ->editColumn('operation_type', function ($row) {
                    $array = [
                        'created' => __('affilate::lang.created'),
                        'updated' => __('affilate::lang.updated'),
                        'reset' => __('affilate::lang.reset'),
                        'deleted' => __('lang_v1.deleted'),
                        'restored' => __('affilate::lang.order_restored')
                    ];
                    return array_key_exists($row->operation_type, $array) ? $array[$row->operation_type] : '';
                })
                ->editColumn('data', function ($row) {
                    if (!empty($row->data)) {
                        $data = json_decode($row->data, true);
                        return implode(', ', $data) . '<br><small>' . count($data) . ' ' . __('affilate::lang.records') . '</small>';
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

        return view('affilate::affilate.sync_log');
    }

    /**
     * Retrives details of a sync log.
     * @param int $id
     * @return Response
     */
    public function getLogDetails($id)
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $log = affilateSyncLog::where('business_id', $business_id)
                                            ->find($id);
            $log_details = json_decode($log->details);
            
            return view('affilate::affilate.partials.log_details')
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
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                Category::where('business_id', $business_id)
                        ->update(['affilate_cat_id' => null]);
                $user_id = request()->session()->get('user.id');
                $this->affilateUtil->createSyncLog($business_id, $user_id, 'categories', 'reset', null);

                $output = ['success' => 1,
                            'msg' => __("affilate::lang.cat_reset_success"),
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
        if (!(auth()->user()->can('superadmin') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                //Update products table
                Product::where('business_id', $business_id)
                        ->update(['affilate_product_id' => null, 'affilate_media_id' => null]);

                $product_ids = Product::where('business_id', $business_id)
                                    ->pluck('id');

                $product_ids = !empty($product_ids) ? $product_ids : [];
                //Update variations table
                Variation::whereIn('product_id', $product_ids)
                        ->update([
                            'affilate_variation_id' => null
                        ]);

                //Update variation templates
                VariationTemplate::where('business_id', $business_id)
                                ->update([
                                    'affilate_attr_id' => null
                                ]);

                Media::where('business_id', $business_id)
                        ->update(['affilate_media_id' => null]);

                $user_id = request()->session()->get('user.id');
                $this->affilateUtil->createSyncLog($business_id, $user_id, 'all_products', 'reset', null);

                $output = ['success' => 1,
                            'msg' => __("affilate::lang.prod_reset_success"),
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
    
    
   public function viewbalance()
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || auth()->user()->can('affilate.access_affilate_balance') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $logs = User::where('business_id', $business_id)
                    ->where('affilate_agent', 1)
                    ->select([
                        'users.*',
                  
                      DB::raw("CONCAT(COALESCE(users.surname, ''),' ',COALESCE(users.first_name, ''),' ',COALESCE(users.last_name,'')) as added_by"),
                      DB::raw('(SELECT SUM(TP2.amount) FROM affilate_paids AS TP2 WHERE
                        TP2.user_id=users.id ) as total_paid'), 
                        DB::raw('(SELECT SUM(TP2.amount) FROM affilate_commissions AS TP2 WHERE
                        TP2.user_id=users.id ) as total_commetion'),
                     
                    ]);
        
   

            return Datatables::of($logs)
                ->editColumn('created_at', function ($row) {
                    $created_at = $this->affilateUtil->format_date($row->created_at, true);
                    $for_humans = \Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->diffForHumans();
                    return $created_at . '<br><small>' . $for_humans . '</small>';
                })
                ->editColumn('total_commetion', function ($row) {
                
                  $total_commetion = $row->total_commetion ;
                
           /*         $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $row->id);
       

        $sell_details = $query->get();
        $total_commetion = 0 ;
        foreach($sell_details as $sell){
            
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price = $sell_line->quantity * ( ($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 );
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion += $sell_line->quantity * $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
            
        }

*/ 

      
        
        
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.$total_commetion.'">'.$total_commetion.'</span>' ;
                })
                ->addColumn('total_remind', function ($row) {
                  $total_commetion = $row->total_commetion ;
                
                /*    $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $row->id);
       

        $sell_details = $query->get();
        $total_commetion = 0 ;
        foreach($sell_details as $sell){
            
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price = $sell_line->quantity * (($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 ) ;
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion += $sell_line->quantity * $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
            
        }

*/ 

      
        
        
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.($total_commetion - $row->total_paid).'">'.($total_commetion - $row->total_paid).'</span>' ; 
                })   
                ->editColumn('total_paid', function ($row) {
                
                  $total_paid = !empty($row->total_paid) ? $row->total_paid : 0 ;
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.$total_paid.'">'.$total_paid.'</span>' ;
                })
                ->addColumn(
                    'action',
                    '
                        <button data-href="{{action(\'\Modules\Affilate\Http\Controllers\AffilateController@createpaid\', ["id"=>$id])}}" class="btn main-bg-dark text-white btn-modal" data-container=".expense_category_modal" > <i class="fa fa-plus"></i> @lang( "messages.add" )</button>'
                ) 
               
                ->rawColumns(['created_at',  'total_commetion', 'total_remind', 'total_paid', 'action'])
                ->make(true);
        }

        return view('affilate::affilate.balance');
    }
  
       
       public function viewpaids()
    {
        $business_id = request()->session()->get('business.id');
        if (!(auth()->user()->can('superadmin') || auth()->user()->can('affilate.affilate_paids_show') || $this->moduleUtil->hasThePermissionInSubscription($business_id, 'affilate_module'))) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            $logs = AffilatePaid::leftjoin('users','affilate_paids.user_id','users.id')
                      ->leftjoin('users as u','affilate_paids.created_by','u.id')
                      ->where('affilate_paids.business_id', $business_id)
                 
                    ->select([
                       'affilate_paids.id',
                       'affilate_paids.created_at',
                       'affilate_paids.amount',
                      DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by"),
                      DB::raw("CONCAT(COALESCE(users.surname, ''),' ',COALESCE(users.first_name, ''),' ',COALESCE(users.last_name,'')) as affilator"),
                     DB::raw('(SELECT SUM(TP2.amount) FROM affilate_commissions AS TP2 WHERE
                        TP2.user_id=affilate_paids.user_id ) as total_commetions'),
                     
                    ]);
        
  

            return Datatables::of($logs)
                ->editColumn('created_at', function ($row) {
                    $created_at = $this->affilateUtil->format_date($row->created_at, true);
                    $for_humans = \Carbon::createFromFormat('Y-m-d H:i:s', $row->created_at)->diffForHumans();
                    return $created_at . '<br><small>' . $for_humans . '</small>';
                }) ->addColumn(
                    'action',
                    '
                        <button data-href="{{action(\'\Modules\Affilate\Http\Controllers\AffilateController@deletepaid\', [$id])}}" class="btn btn-xs btn-danger delete_expense_category"><i class="glyphicon glyphicon-trash"></i> @lang("messages.delete")</button>'
                ) 
           ->addColumn('total_commetion', function ($row) {
               
                 $total_commetion = $row->total_commetions ;
                  /*   $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $row->id);
       

        $sell_details = $query->get();
        $total_commetion = 0 ;
        foreach($sell_details as $sell){
            
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price =  $sell_line->quantity * ( ($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 );
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion += $sell_line->quantity * $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
            
        }
*/


      
        
        
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.$total_commetion.'">'.$total_commetion.'</span>' ;
                })
                ->addColumn('total_remind', function ($row) {
                      $total_commetion = $row->total_commetions ;
                   /*  $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $row->id);
       

        $sell_details = $query->get();
        $total_commetion = 0 ;
        foreach($sell_details as $sell){
            
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price =  $sell_line->quantity * (($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 );
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion +=$sell_line->quantity *  $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
            
        }
*/


      
        
        
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.($total_commetion - $row->total_paid).'">'.($total_commetion - $row->total_paid).'</span>' ; 
                })   
                ->editColumn('total_paid', function ($row) {
                
                  $total_paid = !empty($row->total_paid) ? $row->total_paid : 0 ;
                    return  '<span class="display_currency" data-currency_symbol="true" data-orig-value="'.$total_paid.'">'.$total_paid.'</span>' ;
                })
                
               
                ->rawColumns(['created_at',  'total_commetion', 'total_remind',  'action', 'total_paid'])
                ->make(true);
        }

        return view('affilate::affilate.paids');
    }
  
     public function deletepaid($id)
    {
        if (!auth()->user()->can('affilate.affilate_paids_delete')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                $business_id = request()->session()->get('user.business_id');

                $AffilatePaid = AffilatePaid::where('business_id', $business_id)->findOrFail($id);
                $AffilatePaid->delete();

                $output = ['success' => true,
                            'msg' => __("expense.deleted_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

            return $output;
        }
    }
    
     public function createpaid(Request $request)
    {
        if (!auth()->user()->can('affilate.affilate_paids_create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            
            
            $id = $request->input('id') ;
            $remind = 0;
            $user = '';
            if(!empty($id)){
                $total_commetion = 0;
                
          /*      
                $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $id);
       

        $sell_details = $query->get();
        $total_commetion = 0 ;
        foreach($sell_details as $sell){
            
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price = $sell_line->quantity * (($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 ) ;
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion += $sell_line->quantity * $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
            
            
        }*/
        
          $user =  User::where('id', $id)
                    ->where('affilate_agent', 1)
                    ->select([
                        'users.*',
                  
                      DB::raw("CONCAT(COALESCE(users.surname, ''),' ',COALESCE(users.first_name, ''),' ',COALESCE(users.last_name,'')) as added_by"),
                      DB::raw('(SELECT SUM(TP2.amount) FROM affilate_paids AS TP2 WHERE
                        TP2.user_id=users.id ) as total_paid'),
                      DB::raw('(SELECT SUM(TP2.amount) FROM affilate_commissions AS TP2 WHERE
                        TP2.user_id=users.id ) as total_commetions'),
                    ])->first();


        $remind = $user->total_commetions - $user->total_paid ; 
                
            }
            
         
       
         
            $business_id = request()->session()->get('user.business_id');

             $users = User::where('business_id',$business_id)->where('affilate_agent',1)->pluck('first_name','id');

             
        

         return view('affilate::affilate.create',compact('users','remind','id','user'));
        }
    } 
    
    public function storepaid(Request $request)
    {
        if (!auth()->user()->can('affilate.affilate_paids_create')) {
            abort(403, 'Unauthorized action.');
        }

        if (request()->ajax()) {
            try {
                
                
                $business_id = request()->session()->get('user.business_id');
                  $user_id = request()->session()->get('user.id');
               AffilatePaid::create([
                  'business_id' => $business_id,
                  'created_by' => $user_id,
                  'user_id' => $request->user_id,
                  'amount' => $request->amount,
                  
                  
                  ]) ;

                $output = ['success' => true,
                            'msg' => __("expense.added_success")
                            ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
                $output = ['success' => false,
                            'msg' => __("messages.something_went_wrong")
                        ];
            }

         return $output;
        }
    } 
    
    
    public function affilate_commissions(Request $request)
    {
       
       
       
           try { 
         DB::beginTransaction();
         $user_id = request()->session()->get('user.id');
         $logs = User::where('affilate_agent', 1)
                    ->select([
                        'users.*',
                  
                      DB::raw("CONCAT(COALESCE(users.surname, ''),' ',COALESCE(users.first_name, ''),' ',COALESCE(users.last_name,'')) as added_by"),
                      DB::raw('(SELECT SUM(TP2.amount) FROM affilate_paids AS TP2 WHERE
                        TP2.user_id=users.id ) as total_paid'), 
                        DB::raw('(SELECT SUM(TP2.amount) FROM affilate_commissions AS TP2 WHERE
                        TP2.user_id=users.id ) as total_commetions'),
                     
                    ])->get();
        
       foreach($logs as $row){
           
             $query = Transaction::where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->where('transactions.payment_status', 'paid')
                    ->select(
                        'transactions.id',
                        'transactions.created_by',
                        'transactions.business_id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

     
                  $query->where('transactions.created_by', $row->id);
       

        $sell_details = $query->get();
     
        foreach($sell_details as $sell){
           $total_commetion = 0 ;
          foreach( $sell->sell_lines as $sell_line){
              
            if($sell_line->product->affilate_type == 'percent'){
                
                $price = $sell_line->quantity * ( ($sell_line->variations->sell_price_inc_tax  * $sell_line->product->affilate_comm) / 100 );
                
               $total_commetion += $price ;
                
            }else{
                
              $total_commetion += $sell_line->quantity * $sell_line->product->affilate_comm ;
                
            }  
              
        
              
              
          }
            
            
           AffilateCommission::updateOrCreate([
                  'transaction_id' => $sell->id
                  ],[
                     'business_id' => $sell->business_id ,
                     'user_id' => $sell->created_by ,
                     'amount' => $total_commetion,
                     'created_by' => $user_id,
              ]);
                 
         
         
         
         
            
        }
           
           
           
           
           
           
           
           
           
       }
       
       
       
         DB::commit();
         
    } catch (\Exception $e) {
            DB::rollBack();

          
                $output = ['success' => 0,
                            'msg' => $e->getMessage(),
                        ];
           
        } 


   
   
   
       
    }
    
    
    public function reports()
    {
        if (!auth()->user()->can('affilate.affilate_report_show')) {
            abort(403, 'Unauthorized action.');
    }


        $business_id = request()->session()->get('user.business_id');
        $is_woocommerce = $this->moduleUtil->isModuleInstalled('Woocommerce');
        $is_tables_enabled = $this->transactionUtil->isModuleEnabled('tables');
        $is_service_staff_enabled = $this->transactionUtil->isModuleEnabled('service_staff');
        $is_types_service_enabled = $this->moduleUtil->isModuleEnabled('types_of_service');
        $order_statuses = $this->transactionUtil->order_statuses();
        if (request()->ajax()) {
            $payment_types = $this->transactionUtil->payment_types();
            $with = [];
            $shipping_statuses = $this->transactionUtil->shipping_statusess();
            
            $sells = Transaction::leftJoin('users as u', 'transactions.created_by', '=', 'u.id')
              ->leftJoin('affilate_commissions', 'transactions.id', '=', 'affilate_commissions.transaction_id')
              ->leftJoin('transaction_payments',function($join){
                $join->on('transactions.id', 'transaction_payments.transaction_id')->latest('transaction_payments.id');
            })
            ->where('transactions.business_id', $business_id)
                ->where('transactions.type', 'sell')
                ->where('transactions.status', 'final')
            //      ->where('transactions.process_type', 'ecommerce')
                    ->where('transactions.booking', 0)
             //      ->whereIn('transactions.payment_status',['due','partial'])
             //   ->where('transactions.shipping_status','delivered')
                ->select(
              
                    'transactions.id',
                    'transactions.transaction_date',
                      'transactions.updated_at',
                      'transaction_payments.paid_on',
                    'transactions.is_direct_sale',
                    'transactions.invoice_no',
                    'transactions.booking_icon',
                     'transactions.sell_check',
                    'transactions.commission_agent',
                    'transactions.payment_status',
                    'transactions.final_total',
                    'transactions.trafic_id',
                    'transactions.shipment_id',
                    'transactions.campaign_id',
                    'transactions.shipping_charges',
                    'transactions.refrance_no',
                    'transactions.print1',
                    'transactions.tax_amount',
                    'transactions.discount_amount',
                    'transactions.discount_type',
                    'transactions.total_before_tax',
                    'transactions.rp_redeemed',
                    'transactions.rp_redeemed_amount',
                    'transactions.rp_earned',
                    'transactions.types_of_service_id',
                    'transactions.shipping_status',
                       'transactions.shipmentstatus',
                    'transactions.order_status',
                    'transactions.pay_term_number',
                    'transactions.pay_term_type',
                      'transactions.process_type',
                    'transactions.additional_notes',
                    'transactions.staff_note',
                    'transactions.shipping_details',
                    'affilate_commissions.amount',
                
                  
               
                  DB::raw("CONCAT(COALESCE(u.surname, ''),' ',COALESCE(u.first_name, ''),' ',COALESCE(u.last_name,'')) as added_by"),
             
                    'transactions.service_custom_field_1'
                );

     
          
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $sells->whereIn('transactions.location_id', $permitted_locations);
            }

            //Add condition for created_by,used in sales representative sales report
            if (request()->has('created_by')) {
                $created_by = request()->get('created_by');
                if (!empty($created_by)) {
                    $created_by =request()->get('created_by');
                  $sells->where(function ($sells) use ($created_by) {
                        $sells->where('transactions.created_by', $created_by)
                            ->orwhere('transactions.follow_by', $created_by);
                    });
                //    $sells->where('transactions.created_by', $created_by);
                }
            }

            if (!auth()->user()->can('direct_sell.access') && auth()->user()->can('view_own_sell_only')) {
                $created_by = request()->session()->get('user.id');
                  $sells->where(function ($sells) use ($created_by) {
                        $sells->where('transactions.created_by', $created_by)
                            ->orwhere('transactions.follow_by', $created_by);
                    });
             //   $sells->where('transactions.created_by', request()->session()->get('user.id'));
            }

            if (!empty(request()->input('payment_status')) && request()->input('payment_status') != 'overdue') {
                $sells->where('transactions.payment_status', request()->input('payment_status'));
            } elseif (request()->input('payment_status') == 'overdue') {
                $sells->whereIn('transactions.payment_status', ['due', 'partial'])
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("IF(transactions.pay_term_type='days', DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number DAY) < CURDATE(), DATE_ADD(transactions.transaction_date, INTERVAL transactions.pay_term_number MONTH) < CURDATE())");
            }

            //Add condition for location,used in sales representative expense report
            if (request()->has('location_id')) {
                $location_id = request()->get('location_id');
                if (!empty($location_id)) {
                    $sells->where('transactions.location_id', $location_id);
                }
            }

            if (!empty(request()->input('rewards_only')) && request()->input('rewards_only') == true) {
                $sells->where(function ($q) {
                    $q->whereNotNull('transactions.rp_earned')
                    ->orWhere('transactions.rp_redeemed', '>', 0);
                });
            }

        
            if (!empty(request()->start_date) && !empty(request()->end_date)) {
                $start = request()->start_date;
                $end =  request()->end_date;
                $sells->whereDate('transaction_payments.paid_on', '>=', $start)
                            ->whereDate('transaction_payments.paid_on', '<=', $end);
            }

            //Check is_direct sell
            if (request()->has('is_direct_sale')) {
                $is_direct_sale = request()->is_direct_sale;
                if ($is_direct_sale == 0) {
                    $sells->where('transactions.is_direct_sale', 0);
                    $sells->whereNull('transactions.sub_type');
                }
            }

            //Add condition for commission_agent,used in sales representative sales with commission report
            if (request()->has('commission_agent')) {
                $commission_agent = request()->get('commission_agent');
                if (!empty($commission_agent)) {
                    $sells->where('transactions.commission_agent', $commission_agent);
                }
            }

            if ($is_woocommerce) { 

                $sells->addSelect('transactions.woocommerce_order_id');
                if (request()->only_woocommerce_sells) {
                    $sells->whereNotNull('transactions.woocommerce_order_id');
                }
          } 
            if (!empty(request()->list_for) && request()->list_for == 'service_staff_report') {
                $sells->whereNotNull('transactions.res_waiter_id');
            }

            if (!empty(request()->res_waiter_id)) {
                $sells->where('transactions.res_waiter_id', request()->res_waiter_id);
            }

            if (!empty(request()->input('sub_type'))) {
                $sells->where('transactions.sub_type', request()->input('sub_type'));
            } 
            if (!empty(request()->input('trafic_id'))) {
                $sells->where('transactions.trafic_id', request()->input('trafic_id'));
            } 
            if (!empty(request()->input('shipment_id'))) {
                $sells->where('transactions.shipment_id', request()->input('shipment_id'));
            }  
            if (!empty(request()->input('campaign_id'))) {
                $sells->where('transactions.campaign_id', request()->input('campaign_id'));
            }

            if (!empty(request()->input('created_by'))) {
                $created_by =request()->get('created_by');
                  $sells->where(function ($sells) use ($created_by) {
                        $sells->where('transactions.created_by', $created_by)
                            ->orwhere('transactions.follow_by', $created_by);
                    });
            //    $sells->where('transactions.created_by', request()->input('created_by'));
            }

            if (!empty(request()->input('sales_cmsn_agnt'))) {
                $sells->where('transactions.commission_agent', request()->input('sales_cmsn_agnt'));
            }

            if (!empty(request()->input('service_staffs'))) {
                $sells->where('transactions.res_waiter_id', request()->input('service_staffs'));
            }
            $only_shipments = request()->only_shipments == 'true' ? true : false;
            if ($only_shipments && auth()->user()->can('access_shipping')) {
                $sells->whereNotNull('transactions.shipping_status');
            }

            if (!empty(request()->input('shipping_status'))) {
                $sells->where('transactions.shipping_status', request()->input('shipping_status'));
            } 
            
            if (!empty(request()->input('order_status'))) {
                $sells->where('transactions.order_status', request()->input('order_status'));
            }
            
            $sells->groupBy('transactions.id');

            if (!empty(request()->suspended)) {
                $with = ['sell_lines'];

                if ($is_tables_enabled) {
                    $with[] = 'table';
                }

                if ($is_service_staff_enabled) {
                    $with[] = 'service_staff';
                }

                $sales = $sells->where('transactions.is_suspend', 1)
                            ->with($with)
                            ->addSelect('transactions.is_suspend', 'transactions.res_table_id', 'transactions.res_waiter_id', 'transactions.additional_notes')
                            ->get();

                return view('sale_pos.partials.suspended_sales_modal')->with(compact('sales', 'is_tables_enabled', 'is_service_staff_enabled'));
            }

            $with[] = 'payment_lines';
            if (!empty($with)) {
                $sells->with($with);
            }

            //$business_details = $this->businessUtil->getDetails($business_id);
            if ($this->businessUtil->isModuleEnabled('subscription')) {
                $sells->addSelect('transactions.is_recurring', 'transactions.recur_parent_id');
            }

            $datatable = Datatables::of($sells)
            
             ->addColumn('view', function ($row)  {
                    $html = '<button type="button" title="' . __("lang_v1.view_details") . '" class="main-light-btn btn-xs view_sell"><i class="fa fa-eye-slash" aria-hidden="true"></i></button>';

                

                    return $html;
                })
                ->addColumn(
                    'action',
                    function ($row) use ($only_shipments) {
                        $html = '<div class="btn-group">
                                    <button type="button" class="main-dark-btn dropdown-toggle btn-xs" 
                                        data-toggle="dropdown" aria-expanded="false">' .
                                        __("messages.actions") .
                                        '<span class="sr-only">Toggle Dropdown
                                        </span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-left" role="menu">' ;

                        if (auth()->user()->can("sell.view") || auth()->user()->can("direct_sell.access") || auth()->user()->can("view_own_sell_only")) {
                            $html .= '<li><a href="#" data-href="' . action("SellController@show", [$row->id]) . '" class="btn-modal" data-container=".view_modal"><i class="fas fa-eye" aria-hidden="true"></i> ' . __("messages.view") . '</a></li>';
                        }
                        if (!$only_shipments) {
                            if ($row->is_direct_sale == 0) {
                                if (auth()->user()->can("sell.update")) {
                                    $html .= '<li><a target="_blank" href="' . action('SellPosController@edit', [$row->id]) . '"><i class="fas fa-edit"></i> ' . __("messages.edit") . '</a></li>';
                                }
                            } else {
                                if (auth()->user()->can("direct_sell.access")) {
                                    $html .= '<li><a target="_blank" href="' . action('SellPosController@edit', [$row->id]) . '"><i class="fas fa-edit"></i> ' . __("messages.edit") . '</a></li>';
                                }
                            }

                            if (auth()->user()->can("direct_sell.delete") || auth()->user()->can("sell.delete")) {
                                $html .= '<li><a href="' . action('SellPosController@destroy', [$row->id]) . '" class="delete-sale"><i class="fas fa-trash"></i> ' . __("messages.delete") . '</a></li>';
                            }
                        }
                        if (auth()->user()->can("sell.view") || auth()->user()->can("direct_sell.access")) {
                               if (auth()->user()->can('sell_print')) {
                            $html .= '<li><a href="#" class="print-invoice" data-href="' . route('sell.printInvoice', [$row->id]) . '"><i class="fas fa-print" aria-hidden="true"></i> ' . __("messages.print") . '</a></li>
                                <li><a href="#" class="print-invoice" data-href="' . route('sell.printInvoice', [$row->id]) . '?package_slip=true"><i class="fas fa-file-alt" aria-hidden="true"></i> ' . __("lang_v1.packing_slip") . '</a></li>';
                        }
                        }
                        if (auth()->user()->can("access_shipping")) {
                            $html .= '<li><a href="#" data-href="' . action('SellController@editShipping', [$row->id]) . '" class="btn-modal" data-container=".view_modal"><i class="fas fa-truck" aria-hidden="true"></i>' . __("lang_v1.edit_shipping") . '</a></li>';
                        }
                        if (!$only_shipments) {
                            $html .= '<li class="divider"></li>';
                          if (auth()->user()->can("payment.status")) {
                            if ($row->payment_status != "paid" && (auth()->user()->can("sell.create") || auth()->user()->can("direct_sell.access")) && auth()->user()->can("sell.payments")) {
                                $html .= '<li><a href="' . action('TransactionPaymentController@addPayment', [$row->id]) . '" class="add_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("purchase.add_payment") . '</a></li>';
                            }
                        
                            $html .= '<li><a href="' . action('TransactionPaymentController@show', [$row->id]) . '" class="view_payment_modal"><i class="fas fa-money-bill-alt"></i> ' . __("purchase.view_payments") . '</a></li>';
                            }
                            if (auth()->user()->can("sell.create")) {
                                $html .= '<li><a href="' . action('SellController@duplicateSell', [$row->id]) . '"><i class="fas fa-copy"></i> ' . __("lang_v1.duplicate_sell") . '</a></li>

                            
                                <li><a href="' . action('SellReturnController@substitution', [$row->id]) . '"><i class="fas fa-undo"></i> ' . __("lang_v1.substitution") . '</a></li>
                                 <li><a href="#" class="print-invoices" data-href="' . route('sell.printInvoice.substitution', [$row->id]) . '"><i class="fas fa-file-alt" aria-hidden="true"></i> ' . __("lang_v1.substitution_receipt") . '</a></li>
                                <li><a href="' . action('SellPosController@showInvoiceUrl', [$row->id]) . '" class="view_invoice_url"><i class="fas fa-eye"></i> ' . __("lang_v1.view_invoice_url") . '</a></li>';
                           
                               if (auth()->user()->can('sell_return')) {
                            $html .=   '  <li><a href="' . action('SellReturnController@add', [$row->id]) . '"><i class="fas fa-undo"></i> ' . __("lang_v1.sell_return") . '</a></li>
                                <li><a href="' . action('SellReturnController@Fulladd', [$row->id]) . '"><i class="fas fa-undo"></i> ' . __("lang_v1.full_sell_return") . '</a></li>
                                  <li><a href="' . action('SellReturnController@newadd', [$row->id]) . '"><i class="fas fa-undo"></i> ' . __("lang_v1.false_sell_return") . '</a></li>
                                  ' ;      
                               }    
                            }
                           
                                if (auth()->user()->can('logs.assign')) {   
                       /*         $html .=   '<li><a href="' . action('SellPosController@assign', [$row->id]) . '" class="view_invoice_url"><i class="fas fa-user"></i> ' . __("lang_v1.assign") . '</a></li>';*/
                               $html .=   '<li><button data-href="'.action('SellPosController@calllogorder', [$row->id]). '" style="background: none!important; border: none;display: block;padding: 3px 20px;  clear: both;font-weight: 400; line-height: 1.42857143;  color: #777;white-space: nowrap;" class=" edit_trafic_button"><i class="glyphicon glyphicon-list"></i>' . __("sale.call_logs") . '</button></li>';
                                 
                             }
                            /*  $html .=   '<li><a href="#" class="view_invoice_url"  data-toggle="modal" data-target="#call_logs_modal'.$row->id.'" ><i class="fas fa-user" ></i> ' . __("lang_v1.call_logs") . '</a></li>';*/
                            
                            $html .= '<li><a href="#" data-href="' . action('NotificationController@getTemplate', ["transaction_id" => $row->id,"template_for" => "new_sale"]) . '" class="btn-modal" data-container=".view_modal"><i class="fa fa-envelope" aria-hidden="true"></i>' . __("lang_v1.new_sale_notification") . '</a></li>';
                        }

                        $html .= '</ul></div>';
                      
            
                        return $html;
                    }
                )
                ->removeColumn('id')
                ->editColumn(
                    'final_total',
                    '<span class="display_currency final-total" data-currency_symbol="true" data-orig-value="{{$final_total}}">{{$final_total}}</span>'
                ) ->editColumn(
                    'amount',
                    '<span class="display_currency amount-total" data-currency_symbol="true" data-orig-value="{{$amount}}">{{$amount}}</span>'
                )/* ->editColumn(
                    'total_items',
                    '<span class="products_count" data-orig-value="{{$total_items}}">{{$total_items}}</span>'
                )*/
                ->editColumn(
                    'tax_amount',
                    '<span class="display_currency total-tax" data-currency_symbol="true" data-orig-value="{{$tax_amount}}">{{$tax_amount}}</span>'
                )
              
                 ->editColumn('additional_notes', function ($row) {
                    return  str_limit($row->additional_notes, $limit = 70, $end = '...') ;
                }) 
                ->editColumn('staff_note', function ($row) {
                    return  str_limit($row->staff_note, $limit = 70, $end = '...') ;
                })
                ->editColumn(
                    'total_before_tax',
                    '<span class="display_currency total_before_tax" data-currency_symbol="true" data-orig-value="{{$total_before_tax}}">{{$total_before_tax}}</span>'
                )
                 ->addColumn('mass_delete', function ($row) {
                    return  '<input type="checkbox" class="row-select" value="' . $row->id .'">' ;
                })
                ->editColumn(
                    'discount_amount',
                    function ($row) {
                        $discount = !empty($row->discount_amount) ? $row->discount_amount : 0;

                        if (!empty($discount) && $row->discount_type == 'percentage') {
                            $discount = $row->total_before_tax * ($discount / 100);
                        }

                        return '<span class="display_currency total-discount" data-currency_symbol="true" data-orig-value="' . $discount . '">' . $discount . '</span>';
                    }
                )  ->editColumn(
                    'commission_agent',function ($row) {
                        
                       
                          if(!empty($row->commission_agent)){
                           
                              if(!empty($row->commission_agents->first_name)){
                              
                                 return $row->commission_agents->first_name;      
                                  
                              }
                              
                            
                              
                          }
                       
                            
                            
                      
                    
                })->editColumn(
                    'print1',
                    function ($row) {
                        $discount =  $row->print1 == 1 ? "Printed": "Not Printed yet";

                      

                        return $discount;
                    }
                )
                ->editColumn('transaction_date', '{{@format_datetime($transaction_date)}}')
                ->editColumn(
                    'payment_status',
                    function ($row) {
                        $payment_status = Transaction::getPaymentStatus($row);
                        return (string) view('sell.partials.payment_status', ['payment_status' => $payment_status, 'id' => $row->id]);
                    }
                ) ->editColumn(
                    'trafic_id',function ($row) {
                        if(!empty($row->trafic_resources->name)){
                        $trafic_resource = $row->trafic_resources->name;
                        }else{
                            
                            $trafic_resource = "none";
                        }
                       
                            
                            
                        return $trafic_resource;
                    }
                )->editColumn(
                    'campaign_id',function ($row) {
                        
                       
                          if(!empty($row->campaigns->name)){
                         $trafic_resource = $row->campaigns->name;
                        }else{
                            
                            $trafic_resource = "none";
                        }
                       
                       
                            
                            
                        return $trafic_resource;
                    }
                )->editColumn(
                    'shipment_id',function ($row) {
                        
                       
                          if(!empty($row->shipment->name)){
                         $trafic_resource = $row->shipment->name;
                        }else{
                            
                            $trafic_resource = "none";
                        }
                       
                       
                            
                            
                        return $trafic_resource;
                    }
                )
                
            
                
              ->editColumn('refrance_no', function ($row) {
                     
                     if(!empty($row->refrance_no)) {
                      return '<button type="button" class="btn btn-link btn-modal" data-container=".view_modal" data-href="' . action('SellController@addrefno', [$row->id]) . '">' . $row->refrance_no . '</button>';
                     }else {
                           return '<button type="button" class="btn btn-link btn-modal" data-container=".view_modal" data-href="' . action('SellController@addrefno', [$row->id]) . '">Enter  ReferenceNo </button>';
                     }
                         
                         
                })
            
              ->editColumn(
                    'shipping_charges',
                    '<span class="display_currency shipping_charges" data-currency_symbol="true" data-orig-value="{{$shipping_charges }}">{{$shipping_charges }}</span>'
                ) 
            
                ->editColumn('invoice_no', function ($row) {
                    $invoice_no = $row->invoice_no;
                    if (!empty($row->woocommerce_order_id)) {
                        $invoice_no .= ' <i class="fab fa-wordpress text-primary no-print" title="' . __('lang_v1.synced_from_woocommerce') . '"></i>';
                    }
                    if (!empty($row->return_exists)) {
                        $invoice_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="' . __('lang_v1.some_qty_returned_from_sell') .'"><i class="fas fa-undo"></i></small>';
                    }
                    if (!empty($row->is_recurring)) {
                        $invoice_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="' . __('lang_v1.subscribed_invoice') .'"><i class="fas fa-recycle"></i></small>';
                    }
                       if (!empty($row->sell_check == 1)) {
                        $invoice_no .= ' &nbsp;<small class="label bg-success label-round no-print" style="font-size: 13px" title="' . __('lang_v1.invoice_checked') .'"><i class="fas fa-check-circle"></i></small>';
                    }
 if (!empty($row->new_return_exists)) {
                        $invoice_no .= ' &nbsp;<small class="label bg-red label-round no-print" title="' . __('lang_v1.list_sell_return_partial') .'"><i class="fas fa-undo">need return</i></small>';
                    }
                    if (!empty($row->recur_parent_id)) {
                        $invoice_no .= ' &nbsp;<small class="label bg-info label-round no-print" title="' . __('lang_v1.subscription_invoice') .'"><i class="fas fa-recycle"></i></small>';
                    }
  if ($row->booking_icon == 1) {
                        $invoice_no .= ' &nbsp;<small class="label bg-navy label-round no-print" title="' . __('lang_v1.booking_invoice') .'"><i class="fas fa-business-time"></i></small>';
                    }
                    return $invoice_no;
                })
                ->editColumn('shipping_status', function ($row) use ($shipping_statuses) {
                    $status_color = !empty($this->shipping_status_colors[$row->shipping_status]) ? $this->shipping_status_colors[$row->shipping_status] : 'bg-gray';
                    $status = !empty($row->shipping_status) ? '<a href="#" class="btn-modal shipping-status-label" data-orig-value="'.$row->shipping_status.'" data-status-name="'.$shipping_statuses[$row->shipping_status].'" data-href="' . action('SellController@editShipping', [$row->id]) . '" data-container=".view_modal"><span class="label ' . $status_color .'">' . $shipping_statuses[$row->shipping_status] . '</span></a>' : '';
                     
                    return $status;
                })
                ->editColumn('order_status', function ($row) use ($order_statuses) {
                    $status_color = !empty($this->order_status_colors[$row->order_status]) ? $this->order_status_colors[$row->order_status] : 'bg-gray';
                    $status = !empty($row->order_status) ? '<a href="#" class="btn-modal order-status-label" data-orig-value="'.$row->order_status.'" data-status-name="'.$order_statuses[$row->order_status].'" data-href="' . action('SellController@editstatus', [$row->id]) . '" data-container=".view_modal"><span class="label ' . $status_color .'">' . $order_statuses[$row->order_status] . '</span></a>' : '';
                     
                    return $status;
                })
                ->addColumn('payment_methods', function ($row) use ($payment_types) {
                    $methods = array_unique($row->payment_lines->pluck('method')->toArray());
                    $count = count($methods);
                    $payment_method = '';
                    if ($count == 1) {
                        $payment_method = !empty($methods[0]) ? $payment_types[$methods[0]] : '' ;
                    } elseif ($count > 1) {
                        $payment_method = __('lang_v1.checkout_multi_pay');
                    }

                    $html = !empty($payment_method) ? '<span class="payment-method" data-orig-value="' . $payment_method . '" data-status-name="' . $payment_method . '">' . $payment_method . '</span>' : '';
                    
                    return $html;
                })
                  ->addColumn('logs', function ($row) {
                    return   '<button data-href="'.action('SellPosController@alllogorder', [$row->id]).'" class="btn-xs main-light-btn edit_trafic_button"><i class="glyphicon glyphicon-list"></i> '.__("lang_v1.show_all").'</button>';
                })
                ->setRowAttr([
                    'id' => function ($row) {
                    
                          return  $row->id ;
                       
                    },
                    'data-href' => function ($row) {
                        if (auth()->user()->can("sell.view") || auth()->user()->can("view_own_sell_only")) {
                            return  action('SellController@show', [$row->id]) ;
                        } else {
                            return '';
                        }
                    }, 'style' => function ($row) {
                        if (auth()->user()->can("sell.view") || auth()->user()->can("view_own_sell_only")) {
                            return   $row->print1 == 1 ? 'background:#ffd9be ': 'none';
                        } else {
                            return '';
                        }
                    }]);

            $rawColumns = ['final_total', 'action', 'mass_delete',  'total_items', 'amount', 'advance_status','checksell','shipping_charges', 'total_paid', 'view','order_status', 'refrance_no', 'total_remaining','trafic_id','campaign_id', 'shipment_id', 'payment_status', 'invoice_no', 'discount_amount', 'tax_amount', 'total_before_tax', 'shipping_status', 'types_of_service_name', 'payment_methods', 'return_due','logs','commission_agent'];
                
            return $datatable->rawColumns($rawColumns)
                      ->make(true);
        }

        $business_locations = BusinessLocation::forDropdown($business_id, false);
        
      
            $customers = Contact::customersDropdown($business_id, false);
       
        
        // $customers = Contact::customersDropdown($business_id, false);
        $shipping_statuses = $this->transactionUtil->shipping_statuses();
        $order_statuses = $this->transactionUtil->order_statuses();
        $sales_representative = User::forDropdown($business_id, false, false, true, false, true);
    
   
        return view('affilate::affilate.report')
        ->with(compact('business_locations', 'customers', 'shipping_statuses','order_statuses','sales_representative'));
    }
             
    
    
    
}

