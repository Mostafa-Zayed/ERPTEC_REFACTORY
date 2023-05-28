<?php

namespace Modules\Affilate\Http\Controllers;

use App\BusinessLocation;

use App\Currency;
use App\Transaction;
use App\Business;
use App\Utils\BusinessUtil;
use App\Utils\ModuleUtil;
use Modules\Affilate\Entities\AffilatePaid;
use Modules\Affilate\Entities\AffilateCommission;
use App\Utils\TransactionUtil;
use App\VariationLocationDetails;
use App\Charts\CommonChart;
use Datatables;
use DB;
use Illuminate\Routing\Controller;
use App;
use Auth;
use App\User;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * All Utils instance.
     *
     */
    protected $businessUtil;
    protected $transactionUtil;
    protected $moduleUtil;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        BusinessUtil $businessUtil,
        TransactionUtil $transactionUtil,
        ModuleUtil $moduleUtil
    ) {
        $this->businessUtil = $businessUtil;
        $this->transactionUtil = $transactionUtil;
        $this->moduleUtil = $moduleUtil;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business_id = request()->session()->get('user.business_id');
        
        $user_id = request()->session()->get('user.id');
        $user = User::find($user_id);
        $affilate_agent = !empty($user->affilate_agent) ? $user->affilate_agent : null;
   
        if (!$affilate_agent) {
            
           return redirect('/home');
            
        }
        
        
        
         if(!empty($business_id)) {
              $mytime = Carbon::now();
              $new_time = $mytime->toDateTimeString();
              $new_time = date("Y-m-d H:i:s", strtotime('+0 hours'));
          
             Business::where('id',$business_id)->update(['last_login_time' => $new_time ]);
        }

        $fy = $this->businessUtil->getCurrentFinancialYear($business_id);
        $date_filters['this_fy'] = $fy;
        $date_filters['lastfy'] = date("Y-m-d",strtotime("-1 year"));
        $date_filters['this_month']['start'] = date('Y-m-01');
        $date_filters['this_month']['end'] = date('Y-m-t');
        $date_filters['this_week']['start'] = date('Y-m-d', strtotime('monday this week'));
        $date_filters['this_week']['end'] = date('Y-m-d', strtotime('sunday this week'));

        $currency = Currency::where('id', request()->session()->get('business.currency_id'))->first();
        
        //Chart for sells last 30 days
        $sells_last_30_days = $this->getSellsLast30Days($business_id);
        $labels = [];
        $all_sell_values = [];
        $dates = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = \Carbon::now()->subDays($i)->format('Y-m-d');
            $dates[] = $date;

            $labels[] = date('j M Y', strtotime($date));

            if (!empty($sells_last_30_days[$date])) {
                $all_sell_values[] = (float) $sells_last_30_days[$date];
            } else {
                $all_sell_values[] = 0;
            }
        }

        //Get sell for indivisual locations
        $all_locations = BusinessLocation::forDropdown($business_id)->toArray();
        $location_sells = [];
        $sells_by_location = $this->getSellsLast30Days($business_id, true);
        foreach ($all_locations as $loc_id => $loc_name) {
            $values = [];
            foreach ($dates as $date) {
                $sell = $sells_by_location->first(function ($item) use ($loc_id, $date) {
                    return $item->date == $date &&
                        $item->location_id == $loc_id;
                });
                
                if (!empty($sell)) {
                    $values[] = (float) $sell->total_sells;
                } else {
                    $values[] = 0;
                }
            }
            $location_sells[$loc_id]['loc_label'] = $loc_name;
            $location_sells[$loc_id]['values'] = $values;
        }

        $sells_chart_1 = new CommonChart;

        $sells_chart_1->labels($labels)
                        ->options($this->__chartOptions(__(
                                'home.total_sells',
                                ['currency' => $currency->code]
                            )));

        if (!empty($location_sells)) {
            foreach ($location_sells as $location_sell) {
                $sells_chart_1->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }

        if (count($all_locations) > 1) {
            $sells_chart_1->dataset(__('report.all_locations'), 'line', $all_sell_values);
        }

        //Chart for sells this financial year
        $sells_this_fy = $this->getSellsCurrentFy($business_id, $fy['start'], $fy['end']);

        $labels = [];
        $values = [];

        $months = [];
        $date = strtotime($fy['start']);
        $last   = date('m-Y', strtotime($fy['end']));

        $fy_months = [];
        do {
            $month_year = date('m-Y', $date);
            $fy_months[] = $month_year;

            $month_number = date('m', $date);

            $labels[] = \Carbon::createFromFormat('m-Y', $month_year)
                            ->format('M-Y');
            $date = strtotime('+1 month', $date);

            if (!empty($sells_this_fy[$month_year])) {
                $values[] = (float) $sells_this_fy[$month_year];
            } else {
                $values[] = 0;
            }
        } while ($month_year != $last);

        $fy_sells_by_location = $this->getSellsCurrentFy($business_id, $fy['start'], $fy['end'], true);
        $fy_sells_by_location_data = [];

        foreach ($all_locations as $loc_id => $loc_name) {
            $values_data = [];
            foreach ($fy_months as $month) {
                $sell = $fy_sells_by_location->first(function ($item) use ($loc_id, $month) {
                    return $item->yearmonth == $month &&
                        $item->location_id == $loc_id;
                });
                
                if (!empty($sell)) {
                    $values_data[] = (float) $sell->total_sells;
                } else {
                    $values_data[] = 0;
                }
            }
            $fy_sells_by_location_data[$loc_id]['loc_label'] = $loc_name;
            $fy_sells_by_location_data[$loc_id]['values'] = $values_data;
        }

        $sells_chart_2 = new CommonChart;
        $sells_chart_2->labels($labels)
                    ->options($this->__chartOptions(__(
                                'home.total_sells',
                                ['currency' => $currency->code]
                            )));
        if (!empty($fy_sells_by_location_data)) {
            foreach ($fy_sells_by_location_data as $location_sell) {
                $sells_chart_2->dataset($location_sell['loc_label'], 'line', $location_sell['values']);
            }
        }
        if (count($all_locations) > 1) {
            $sells_chart_2->dataset(__('report.all_locations'), 'line', $values);
        }

        //Get Dashboard widgets from module
        $module_widgets = $this->moduleUtil->getModuleData('dashboard_widget');

        $widgets = [];

        foreach ($module_widgets as $widget_array) {
            if (!empty($widget_array['position'])) {
                $widgets[$widget_array['position']][] = $widget_array['widget'];
            }
        }
        
          $sliders = Slider::all();

        if(!$affilate_agent){
            
               return view('home.index', compact('date_filters', 'sells_chart_1', 'sells_chart_2', 'widgets', 'all_locations','sliders'));
        }else{
            
            
           return view('affilate::user.dashboard', compact('date_filters', 'sells_chart_1', 'sells_chart_2', 'widgets', 'all_locations','sliders'));
        }
     
        
    }
    
    public function getSellsLast30Days($business_id, $group_by_location = false)
    {
        
           $user_id = request()->session()->get('user.id');
        $query = Transaction::leftjoin('transactions as SR', function ($join) {
            $join->on('SR.return_parent_id', '=', 'transactions.id')
                                    ->where('SR.type', 'sell_return');
        })
                            ->where('transactions.business_id', $business_id)
                            ->where('transactions.type', 'sell')
                            ->where('transactions.created_by', $user_id)
                            ->where('transactions.status', 'final')
                            ->whereBetween(DB::raw('date(transactions.transaction_date)'), [\Carbon::now()->subDays(30), \Carbon::now()]);

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }

        $query->select(
            DB::raw("DATE_FORMAT(transactions.transaction_date, '%Y-%m-%d') as date"),
            DB::raw("SUM( transactions.final_total - COALESCE(SR.final_total, 0) ) as total_sells")
        )
        ->groupBy(DB::raw('Date(transactions.transaction_date)'));

        if ($group_by_location) {
            $query->addSelect('transactions.location_id');
            $query->groupBy('transactions.location_id');
        }
        $sells = $query->get();

        if (!$group_by_location) {
            $sells = $sells->pluck('total_sells', 'date');
        }

        return $sells;
    }

  public function getSellsCurrentFy($business_id, $start, $end, $group_by_location = false)
    {
            $user_id = request()->session()->get('user.id');
        $query = Transaction::leftjoin('transactions as SR', function ($join) {
            $join->on('SR.return_parent_id', '=', 'transactions.id')
                                    ->where('SR.type', 'sell_return');
        })
                            ->where('transactions.business_id', $business_id)
                            ->where('transactions.created_by', $user_id)
                            ->where('transactions.type', 'sell')
                            ->where('transactions.status', 'final')
                            ->whereBetween(DB::raw('date(transactions.transaction_date)'), [$start, $end]);

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }
        
        $query->groupBy(DB::raw("DATE_FORMAT(transactions.transaction_date, '%Y-%m')"))
        ->select(
            DB::raw("DATE_FORMAT(transactions.transaction_date, '%m-%Y') as yearmonth"),
            DB::raw("SUM( transactions.final_total - COALESCE(SR.final_total, 0)) as total_sells")
        );
        if ($group_by_location) {
            $query->addSelect('transactions.location_id');
            $query->groupBy('transactions.location_id');
        }

        $sells = $query->get();
        if (!$group_by_location) {
            $sells = $sells->pluck('total_sells', 'yearmonth');
        }
        
        return $sells;
    }

    /**
     * Retrieves purchase and sell details for a given time period.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTotals()
    {
        if (request()->ajax()) {
            $start = request()->start;
            $end = request()->end;
            $business_id = request()->session()->get('user.business_id');
            $user_id = request()->session()->get('user.id');

            $purchase_details = $this->getPurchaseTotals($business_id, $start, $end);

            $sell_details = $this->getSellTotals($business_id, $start, $end,null,$user_id);
            
            $total_commetion = $this->getCommetionTotals($business_id, $start, $end,null,$user_id);
            $total_paid = $this->getPaidTotals($business_id, $start, $end,null,$user_id);

            $transaction_types = [
                'purchase_return', 'stock_adjustment', 'sell_return', 'expense'
            ];

            $transaction_totals = $this->transactionUtil->getTransactionTotals(
                $business_id,
                $transaction_types,
                $start,
                $end,
                null,
                $user_id
            );

            $total_purchase_inc_tax = !empty($purchase_details['total_purchase_inc_tax']) ? $purchase_details['total_purchase_inc_tax'] : 0;
            $total_purchase_return_inc_tax = $transaction_totals['total_purchase_return_inc_tax'];
            $total_adjustment = $transaction_totals['total_adjustment'];

            $total_purchase = $total_purchase_inc_tax - $total_purchase_return_inc_tax - $total_adjustment;
            $output = $purchase_details;
            $output['total_purchase'] = $total_purchase;

            $total_sell_inc_tax = !empty($sell_details['total_sell_inc_tax']) ? $sell_details['total_sell_inc_tax'] : 0;
            $total_sell_return_inc_tax = !empty($transaction_totals['total_sell_return_inc_tax']) ? $transaction_totals['total_sell_return_inc_tax'] : 0;

       //     $output['total_sell'] = $total_sell_inc_tax - $total_sell_return_inc_tax;
            $output['total_sell'] = $sell_details['total_count'];

            $output['invoice_due'] = $sell_details['total_due_count'];
            $output['total_paid'] = $sell_details['total_paid_count'];
            
            
            $output['total_expense'] = $transaction_totals['total_expense'];
            
            $output['total_commetion'] = $total_commetion['total_commetion'];
            $output['total_paids'] = $total_paid['total_paids'];
            $output['total_remind'] =  $total_commetion['total_commetion'] - $total_paid['total_paids']  ;
            
            return $output;
        }
    }

    public function getSellTotals($business_id, $start_date = null, $end_date = null, $location_id = null, $created_by = null)
    {
        $query = Transaction::where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('transaction_date', '<=', $end_date);
        }

        //Filter by the location
        if (!empty($location_id)) {
            $query->where('transactions.location_id', $location_id);
        }

        if (!empty($created_by)) { }
            $query->where('transactions.created_by', $created_by);
       

        $sell_details = $query->get();


      $paid = Transaction::where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
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

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $paid->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $paid->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $paid->whereDate('transaction_date', '<=', $end_date);
        }

        //Filter by the location
        if (!empty($location_id)) {
            $paid->where('transactions.location_id', $location_id);
        }

        if (!empty($created_by)) { }
            $paid->where('transactions.created_by', $created_by);
       

        $sell_details_count_paid = $paid->get();
        
        
      $due = Transaction::where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
                    ->where('transactions.status', 'final')
                    ->whereIn('transactions.payment_status', ['due','partial'])
                    ->select(
                        'transactions.id',
                        'final_total',
                        DB::raw("(final_total - tax_amount) as total_exc_tax"),
                        DB::raw('(SELECT SUM(IF(tp.is_return = 1, -1*tp.amount, tp.amount)) FROM transaction_payments as tp WHERE tp.transaction_id = transactions.id) as total_paid'),
                        DB::raw('SUM(total_before_tax) as total_before_tax'),
                        'shipping_charges'
                    )
                    ->groupBy('transactions.id');

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $due->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $due->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $due->whereDate('transaction_date', '<=', $end_date);
        }

        //Filter by the location
        if (!empty($location_id)) {
            $due->where('transactions.location_id', $location_id);
        }

        if (!empty($created_by)) { }
            $due->where('transactions.created_by', $created_by);
       

        $sell_details_count = $due->get();
        
        
        $output['total_sell_inc_tax'] = $sell_details->sum('final_total');
        //$output['total_sell_exc_tax'] = $sell_details->sum('total_exc_tax');
        $output['total_sell_exc_tax'] = $sell_details->sum('total_before_tax');
        $output['invoice_due'] = $sell_details->sum('final_total') - $sell_details->sum('total_paid');
        $output['total_paid'] =  $sell_details->sum('total_paid');
        $output['total_paid_count'] =  $sell_details_count_paid->count();
        $output['total_due_count'] =  $sell_details_count->count();
        $output['total_count'] =  $sell_details->count();
        $output['total_shipping_charges'] = $sell_details->sum('shipping_charges');

        return $output;
    }
    
    public function getPaidTotals($business_id, $start_date = null, $end_date = null, $location_id = null, $created_by = null)
    {
        $query = AffilatePaid::where('user_id', $created_by)
                  
                    ->where('business_id', $business_id)
                  
                   
                   ->groupBy('affilate_paids.id');

        //Check for permitted locations of a user
  

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(created_at)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('created_at', '<=', $end_date);
        }

     

        $sell_details = $query->get();
      
    


        $output['total_paids'] = $sell_details->sum('amount');
      
      
        
        

        return $output;
    }
   public function getCommetionTotals($business_id, $start_date = null, $end_date = null, $location_id = null, $created_by = null)
    {
        
        
      $query =   AffilateCommission::where('user_id',$created_by);
      
         if (!empty($start_date) && !empty($end_date)) {
          //  $query->whereBetween(DB::raw('date(created_at)'), [$start_date, $end_date]);
          $query->whereDate('created_at', '>=', $start_date)
                            ->whereDate('created_at', '<=', $end_date);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('created_at', '<=', $end_date);
        }


    $total_commetion = $query->get()->sum('amount');
       /* 
        
        $query = Transaction::where('transactions.business_id', $business_id)
                  
                    ->where('transactions.type', 'sell')
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

        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('transaction_date', '<=', $end_date);
        }

        //Filter by the location
        if (!empty($location_id)) {
            $query->where('transactions.location_id', $location_id);
        }

        if (!empty($created_by)) { }
            $query->where('transactions.created_by', $created_by);
       

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

        $output['total_commetion'] = $total_commetion;
      
      
        
        

        return $output;
    }

    public function getPurchaseTotals($business_id, $start_date = null, $end_date = null, $location_id = null)
    {
          $user_id = request()->session()->get('user.id');
        $query = Transaction::where('business_id', $business_id)
                        ->where('type', 'purchase')
                        ->where('created_by', $user_id)
                        ->select(
                            'final_total',
                            DB::raw("(final_total - tax_amount) as total_exc_tax"),
                            DB::raw("SUM((SELECT SUM(tp.amount) FROM transaction_payments as tp WHERE tp.transaction_id=transactions.id)) as total_paid"),
                            DB::raw('SUM(total_before_tax) as total_before_tax'),
                            'shipping_charges'
                        )
                        ->groupBy('transactions.id');
        
        //Check for permitted locations of a user
        $permitted_locations = auth()->user()->permitted_locations();
        if ($permitted_locations != 'all') {
            $query->whereIn('transactions.location_id', $permitted_locations);
        }

        if (!empty($start_date) && !empty($end_date)) {
            $query->whereBetween(DB::raw('date(transaction_date)'), [$start_date, $end_date]);
        }

        if (empty($start_date) && !empty($end_date)) {
            $query->whereDate('transaction_date', '<=', $end_date);
        }

        //Filter by the location
        if (!empty($location_id)) {
            $query->where('transactions.location_id', $location_id);
        }

        $purchase_details = $query->get();

        $output['total_purchase_inc_tax'] = $purchase_details->sum('final_total');
        //$output['total_purchase_exc_tax'] = $purchase_details->sum('total_exc_tax');
        $output['total_purchase_exc_tax'] = $purchase_details->sum('total_before_tax');
        $output['purchase_due'] = $purchase_details->sum('final_total') -
                                    $purchase_details->sum('total_paid');
        $output['total_shipping_charges'] = $purchase_details->sum('shipping_charges');

        return $output;
    }
    /**
     * Retrieves sell products whose available quntity is less than alert quntity.
     *
     * @return \Illuminate\Http\Response
     */
    public function getProductStockAlert(Request $request)
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');

            $query = VariationLocationDetails::join(
                'product_variations as pv',
                'variation_location_details.product_variation_id',
                '=',
                'pv.id'
            )
                    ->join(
                        'variations as v',
                        'variation_location_details.variation_id',
                        '=',
                        'v.id'
                    )
                    ->join(
                        'products as p',
                        'variation_location_details.product_id',
                        '=',
                        'p.id'
                    )
                    ->leftjoin(
                        'business_locations as l',
                        'variation_location_details.location_id',
                        '=',
                        'l.id'
                    )
                    ->leftjoin('units as u', 'p.unit_id', '=', 'u.id')
                    ->where('p.business_id', $business_id)
                    ->where('p.enable_stock', 1)
                    ->where('p.is_inactive', 0)
                    ->whereRaw('variation_location_details.qty_available <= p.alert_quantity');

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('variation_location_details.location_id', $permitted_locations);
            }

            $products = $query->select(
                'p.name as product',
                'p.type',
                'pv.name as product_variation',
                'v.name as variation',
                'l.name as location',
                'variation_location_details.qty_available as stock',
                'u.short_name as unit'
            )
                    ->groupBy('variation_location_details.id')
                    ->orderBy('stock', 'asc');
          $lot_number = $request->get('lot_number');
           if(!empty($lot_number)){
                $query->leftjoin('purchase_lines', 'p.id', '=', 'purchase_lines.product_id');
                $query->where('purchase_lines.lot_number', $lot_number);
           }
           
           $location_id = $request->get('location_id');
           if(!empty($location_id)){
            
                $query->where('variation_location_details.location_id', $location_id);
           }
            return Datatables::of($products)
                ->editColumn('product', function ($row) {
                    if ($row->type == 'single') {
                        return $row->product;
                    } else {
                        return $row->product . ' - ' . $row->product_variation . ' - ' . $row->variation;
                    }
                })
                ->editColumn('stock', function ($row) {
                    $stock = $row->stock ? $row->stock : 0 ;
                    return '<span data-is_quantity="true" class="display_currency" data-currency_symbol=false>'. (float)$stock . '</span> ' . $row->unit;
                })
                ->removeColumn('unit')
                ->removeColumn('type')
                ->removeColumn('product_variation')
                ->removeColumn('variation')
                ->rawColumns([2])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchasePaymentDues()
    {
        if (request()->ajax()) {
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'purchase')
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(c.pay_term_type = 'days', c.pay_term_number, 30 * c.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as supplier',
                'ref_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->editColumn('ref_no', function ($row) {
                    if (auth()->user()->can('purchase.view')) {
                        return  '<a href="#" data-href="' . action('PurchaseController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->ref_no . '</a>';
                    }
                    return $row->ref_no;
                })
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([1, 2])
                ->make(false);
        }
    }

    /**
     * Retrieves payment dues for the purchases.
     *
     * @return \Illuminate\Http\Response
     */
    public function getSalesPaymentDues()
    {
        if (request()->ajax()) {
                $user_id = request()->session()->get('user.id');
            $business_id = request()->session()->get('user.business_id');
            $today = \Carbon::now()->format("Y-m-d H:i:s");

            $query = Transaction::join(
                'contacts as c',
                'transactions.contact_id',
                '=',
                'c.id'
            )
                    ->leftJoin(
                        'transaction_payments as tp',
                        'transactions.id',
                        '=',
                        'tp.transaction_id'
                    )
                    ->where('transactions.business_id', $business_id)
                    ->where('transactions.type', 'sell')
                    ->where('transactions.created_by', $user_id)
                    ->where('transactions.payment_status', '!=', 'paid')
                    ->whereNotNull('transactions.pay_term_number')
                    ->whereNotNull('transactions.pay_term_type')
                    ->whereRaw("DATEDIFF( DATE_ADD( transaction_date, INTERVAL IF(transactions.pay_term_type = 'days', transactions.pay_term_number, 30 * transactions.pay_term_number) DAY), '$today') <= 7");

            //Check for permitted locations of a user
            $permitted_locations = auth()->user()->permitted_locations();
            if ($permitted_locations != 'all') {
                $query->whereIn('transactions.location_id', $permitted_locations);
            }

            $dues =  $query->select(
                'transactions.id as id',
                'c.name as customer',
                'transactions.invoice_no',
                'final_total',
                DB::raw('SUM(tp.amount) as total_paid')
            )
                        ->groupBy('transactions.id');

            return Datatables::of($dues)
                ->addColumn('due', function ($row) {
                    $total_paid = !empty($row->total_paid) ? $row->total_paid : 0;
                    $due = $row->final_total - $total_paid;
                    return '<span class="display_currency" data-currency_symbol="true">' .
                    $due . '</span>';
                })
                ->editColumn('invoice_no', function ($row) {
                    if (auth()->user()->can('sell.view')) {
                        return  '<a href="#" data-href="' . action('SellController@show', [$row->id]) . '"
                                    class="btn-modal" data-container=".view_modal">' . $row->invoice_no . '</a>';
                    }
                    return $row->invoice_no;
                })
                ->removeColumn('id')
                ->removeColumn('final_total')
                ->removeColumn('total_paid')
                ->rawColumns([1, 2])
                ->make(false);
        }
    }

    public function loadMoreNotifications()
    {
        $notifications = auth()->user()->notifications()->orderBy('created_at', 'DESC')->paginate(10);

        if (request()->input('page') == 1) {
            auth()->user()->unreadNotifications->markAsRead();
        }

        $notifications_data = [];
        foreach ($notifications as $notification) {
            $data = $notification->data;
            if (in_array($notification->type, [\App\Notifications\RecurringInvoiceNotification::class])) {
                $msg = '';
                $icon_class = '';
                $link = '';
                if ($notification->type ==
                    \App\Notifications\RecurringInvoiceNotification::class) {
                    $msg = !empty($data['invoice_status']) && $data['invoice_status'] == 'draft' ?
                        __(
                            'lang_v1.recurring_invoice_error_message',
                            ['product_name' => $data['out_of_stock_product'], 'subscription_no' => !empty($data['subscription_no']) ? $data['subscription_no'] : '']
                        ) :
                        __(
                            'lang_v1.recurring_invoice_message',
                            ['invoice_no' => !empty($data['invoice_no']) ? $data['invoice_no'] : '', 'subscription_no' => !empty($data['subscription_no']) ? $data['subscription_no'] : '']
                        );
                    $icon_class = !empty($data['invoice_status']) && $data['invoice_status'] == 'draft' ? "fas fa-exclamation-triangle bg-yellow" : "fas fa-recycle bg-green";
                    $link = action('SellPosController@listSubscriptions');
                }

                $notifications_data[] = [
                    'msg' => $msg,
                    'icon_class' => $icon_class,
                    'link' => $link,
                    'read_at' => $notification->read_at,
                    'created_at' => $notification->created_at->diffForHumans()
                ];
            } else {
                $module_notification_data = $this->moduleUtil->getModuleData('parse_notification', $notification);
                if (!empty($module_notification_data)) {
                    foreach ($module_notification_data as $module_data) {
                        if (!empty($module_data)) {
                            $notifications_data[] = $module_data;
                        }
                    }
                }
            }
        }

        return view('layouts.partials.notification_list', compact('notifications_data'));
    }

    /**
     * Function to count total number of unread notifications
     *
     * @return json
     */
    public function getTotalUnreadNotifications()
    {
        $total_unread = auth()->user()->unreadNotifications->count();

        return [
            'total_unread' => $total_unread
        ];
    }

    private function __chartOptions($title)
    {
        return [
            'yAxis' => [
                    'title' => [
                        'text' => $title
                    ]
                ], 
            'legend' => [
                'align' => 'right',
                'verticalAlign' => 'top',
                'floating' => true, 
                'layout' => 'vertical'
            ],
        ];
    }
    
    
    
    
    
    
    
  public function setHomeLang($lang) {
        
       
     try {
         $user_id  = request()->session()->get('user.id');
      
             User::where('id', $user_id)->update(array('language' => $lang));
             $output = ['success' => 1,
                                'msg' => 'Profile updated successfully'
                            ]; 
         }  catch (\Exception $e) {
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            
            $output = ['success' => 0,
                            'msg' => 'Something went wrong, please try again'
                        ];
        }
        
        
         session()->put('user.language', $lang);
     
        
           return redirect()->back();
          
    }
    
    
    
    
}
