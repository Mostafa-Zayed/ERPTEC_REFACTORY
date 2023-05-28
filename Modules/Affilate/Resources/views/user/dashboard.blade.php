@extends('layouts.app')
@section('title', __('home.home'))

@section('content')
<div class="dashboard-p main-bg no-print">
    <div class="section-head d-flex align-items-center justify-content-between mb-4">
        <h3>Overview</h3>
    </div>
    <div class="section-body">
        <!-- Start Statistics -->
        <div class="row mb-2">
		    <div class="col-md-12 col-xs-12">
    			<div class="btn-group pull-left" data-toggle="buttons">
    			    <label class="btn main-light-btn active button4">
    				    <input type="radio" name="date-filter" data-start="{{ date('Y-m-d') }}" data-end="{{ date('Y-m-d') }}" checked> {{ __('home.today') }}
      				</label>
      				<label class="btn main-light-btn button4">
        				<input type="radio" name="date-filter" data-start="{{ $date_filters['this_week']['start']}}" data-end="{{ $date_filters['this_week']['end']}}"> {{ __('home.this_week') }}
      				</label>
      				<label class="btn main-light-btn button4">
        				<input type="radio" name="date-filter" data-start="{{ $date_filters['this_month']['start']}}" data-end="{{ $date_filters['this_month']['end']}}"> {{ __('home.this_month') }}
      				</label>
      				<label class="btn main-light-btn button4">
        				<input type="radio" name="date-filter"  data-start="{{ $date_filters['this_fy']['start']}}" data-end="{{ $date_filters['this_fy']['end']}}"> {{ __('home.this_fy') }}
      				</label>
      				<label class="btn main-light-btn button4">
        				<input type="radio" name="date-filter" data-start="{{ $date_filters['lastfy']}}" data-end="{{ date('Y-m-d') }}"> {{ __('home.last_fy') }}
      				</label>
                </div>
    		</div>
    	</div>
        <div class="row mb-5">
            @if (auth()->user()->can("purchase.create"))
                <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                    <div class="overview-box overview-box-1 text-center">
                        <span class="text-white total_purchase"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                        <p class="mb-0">{{ __('home.total_purchase') }}</p>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                    <div class="overview-box overview-box-2 text-center">
                        <span class="text-white purchase_due"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                        <p class="mb-0">{{ __('home.purchase_due') }}</p>
                    </div>
                </div>
            @endif
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-3 text-center">
                    <span class="text-white total_sell"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('home.total_sell_count') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-4 text-center">
                    <span class="text-white invoice_due"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('home.invoice_due') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-5 text-center">
                    <span class="text-white total_paid"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('sale.total_paid') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-6 text-center">
                    <span class="text-white total_commetion"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('affilate::lang.total_commetion') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-7 text-center">
                    <span class="text-white total_paids"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('affilate::lang.total_paids') }}</p>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 mb-2 mb-lg-2">
                <div class="overview-box overview-box-8 text-center">
                    <span class="text-white total_remind"><i class="fas fa-sync fa-spin fa-fw"></i></span>
                    <p class="mb-0">{{ __('affilate::lang.total_remind') }}</p>
                </div>
            </div>
        </div>
        <!-- End Statistics -->
        <div class="row">
            <!-- Start Left Part -->
            <div class="col-lg-8 order-2 order-lg-1">
                <!-- Start Chart -->
                @if(!empty($widgets['after_sale_purchase_totals']))
                    @foreach($widgets['after_sale_purchase_totals'] as $widget)
                        {!! $widget !!}
                    @endforeach
                @endif
                @if(!empty($all_locations))
                    <div class="default-box">
                        <div class="default-box-head d-flex align-items-center justify-content-between">
                            <h4>{{ __('home.sells_last_30_days') }}</h4>
                        </div>
                        <div class="default-box-body home-tables">
                             {!! $sells_chart_1->container() !!}
                        </div>
              		</div>
                @endif
                @if(!empty($widgets['after_sales_last_30_days']))
                    @foreach($widgets['after_sales_last_30_days'] as $widget)
                        {!! $widget !!}
                    @endforeach
                @endif
                
                @if(!empty($all_locations))
                    <div class="default-box">
                        <div class="default-box-head d-flex align-items-center justify-content-between">
                            <h4>{{ __('home.sells_current_fy') }}</h4>
                        </div>
                        <div class="default-box-body home-tables">
                            {!! $sells_chart_2->container() !!}
                        </div>
                    </div>
                @endif
                @if(!empty($widgets['after_sales_current_fy']))
                  @foreach($widgets['after_sales_current_fy'] as $widget)
                    {!! $widget !!}
                  @endforeach
                @endif
              	<!-- products less than alert quntity -->
                @if(!empty($widgets['after_dashboard_reports']))
                  @foreach($widgets['after_dashboard_reports'] as $widget)
                    {!! $widget !!}
                  @endforeach
                @endif
                <!-- End Chart -->
                
                <!-- Tables Box -->
                <div class="row">
                    <!-- Sales Table -->
                    <div class="col-sm-12">
                        <div class="default-box">
                            <div class="default-box-head d-flex align-items-center justify-content-between mb-0">
                                <h4>{{ __('lang_v1.sales_payment_dues') }} @show_tooltip(__('lang_v1.tooltip_sales_payment_dues'))</h4>
                            </div>
                            <div class="default-box-body home-tables">
                                <div class="table-responsive">
                                    <table class="table table-overview" id="sales_payment_dues_table">
                                        <thead>
                                            <tr>
                                                <th>@lang( 'contact.customer' )</th>
                                                <th>@lang( 'sale.invoice_no' )</th>
                                                <th>@lang( 'home.due_amount' )</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- End Left Part -->
            <!-- Start Right Part -->
            <div class="col-lg-4 order-1 order-lg-2">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="default-box">
                            <div class="default-box-head d-flex align-items-center justify-content-between">
                                <h4>@lang('lang_v1.quick_action')</h4>
                            </div>
                            <div class="default-box-body">
                                <div class="row">
                                    @if (auth()->user()->can('product.create')) 
                                        <div class="col-md-6 text-center mb-3">
                                            <a href="{{url('products/create')}}" class="d-block quick-action">
                                                <img src="{{asset('new_assets/images/link_icons/packet.png')}}" alt="">
                                                <h6>@lang('product.add_product')</h6>
                                            </a>
                                        </div>
                                    @endif
                                    @if (auth()->user()->can("purchase.create"))
                                        <div class="col-md-6 text-center mb-3">
                                            <a href="{{url('purchases/create')}}" class="d-block quick-action">
                                                <img src="{{asset('new_assets/images/link_icons/shopping-bag.png')}}" alt="">
                                                <h6>@lang('purchase.add_purchase')</h6>
                                            </a>
                                        </div>
                                    @endif
                                    {{--
                                    @if (auth()->user()->can('sell.create'))  
                                        <div class="col-md-6 text-center mb-3">
                                            <a href="{{action('SellPosController@create')}}" class="d-block quick-action">
                                                <img src="{{asset('new_assets/images/link_icons/speaker.png')}}" alt="">
                                                <h6>@lang('sale.add_sale')</h6>
                                            </a>
                                        </div>
                                    @endif
                                    --}}
                                    @if(auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                                        <div class="col-md-6 text-center mb-3">
                                            <a href="{{url('sellss/search')}}" class="d-block quick-action">
                                                <img src="{{asset('new_assets/images/link_icons/speaker.png')}}" alt="">
                                                <h6>@lang('sale.sells')</h6>
                                            </a>
                                        </div>
                                    @endif
                                    <div class="col-md-6 text-center mb-3">
                                        <a href="{{url('affilate/affilate-products')}}" class="d-block quick-action">
                                            <img src="{{asset('new_assets/images/link_icons/group-3.png')}}" alt="">
                                            <h6>@lang('lang_v1.list_products')</h6>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{--
<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
    </h1>
</section>
--}}
@stop
@section('javascript')
    <script>
        
    $(document).ready(function() {
    var start = $('input[name="date-filter"]:checked').data('start');
    var end = $('input[name="date-filter"]:checked').data('end');
    update_statistics(start, end);
    $(document).on('change', 'input[name="date-filter"]', function() {
        var start = $('input[name="date-filter"]:checked').data('start');
        var end = $('input[name="date-filter"]:checked').data('end');
        update_statistics(start, end);
    });

    //atock alert datatables
    var stock_alert_table = $('#stock_alert_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        searching: false,
        dom: 'tirp',
        buttons: [],
        ajax: '/home/product-stock-alert',
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#stock_alert_table'));
        },
    });
    //payment dues datatables
    var purchase_payment_dues_table = $('#purchase_payment_dues_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        searching: false,
        dom: 'tirp',
        buttons: [],
        ajax: '/home/purchase-payment-dues',
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#purchase_payment_dues_table'));
        },
    });

    //Sales dues datatables
    var sales_payment_dues_table = $('#sales_payment_dues_table').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        searching: false,
        dom: 'tirp',
        buttons: [],
        ajax: '/home/sales-payment-dues',
        fnDrawCallback: function(oSettings) {
            __currency_convert_recursively($('#sales_payment_dues_table'));
        },
    });

    //Stock expiry report table
    stock_expiry_alert_table = $('#stock_expiry_alert_table').DataTable({
        processing: true,
        serverSide: true,
        searching: false,
        dom: 'tirp',
        ajax: {
            url: '/reports/stock-expiry',
            data: function(d) {
                d.exp_date_filter = $('#stock_expiry_alert_days').val();
            },
        },
        order: [[3, 'asc']],
        columns: [
            { data: 'product', name: 'p.name' },
            { data: 'location', name: 'l.name' },
            { data: 'stock_left', name: 'stock_left' },
            { data: 'exp_date', name: 'exp_date' },
        ],
        fnDrawCallback: function(oSettings) {
            __show_date_diff_for_human($('#stock_expiry_alert_table'));
            __currency_convert_recursively($('#stock_expiry_alert_table'));
        },
    });
});

function update_statistics(start, end) {
    var data = { start: start, end: end };
    //get purchase details
    var loader = '<i class="fas fa-sync fa-spin fa-fw margin-bottom"></i>';
    $('.total_purchase').html(loader);
    $('.purchase_due').html(loader);
    $('.total_sell').html(loader);
    $('.invoice_due').html(loader);
    $('.total_commetion').html(loader);
    $('.total_paids').html(loader);
    $('.total_remind').html(loader);
    $('.total_paid').html(loader);
    $('.total_expense').html(loader);
    $.ajax({
        method: 'get',
        url: '/affilate/home/get-totals',
        dataType: 'json',
        data: data,
        success: function(data) {
            //purchase details
            $('.total_purchase').html(__currency_trans_from_en(data.total_purchase, true));
            $('.purchase_due').html(__currency_trans_from_en(data.purchase_due, true));

            //sell details
            $('.total_sell').html(__currency_trans_from_en(data.total_sell, false));
            $('.invoice_due').html(__currency_trans_from_en(data.invoice_due, false));
            $('.total_commetion').html(__currency_trans_from_en(data.total_commetion, true));
            $('.total_paids').html(__currency_trans_from_en(data.total_paids, true));
            $('.total_remind').html(__currency_trans_from_en(data.total_remind, true));
            $('.total_paid').html(__currency_trans_from_en(data.total_paid, false));
            //expense details
            $('.total_expense').html(__currency_trans_from_en(data.total_expense, true));
        },
    });
}

        
    </script>
    @if(!empty($all_locations))
      {!! $sells_chart_1->script() !!}
      {!! $sells_chart_2->script() !!}
    @endif

@endsection

