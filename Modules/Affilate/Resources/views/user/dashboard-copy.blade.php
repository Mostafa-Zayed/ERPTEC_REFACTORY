<style>
    .whatsapp-box-link{
        text-align:center;
        background: #25d366;
        color: #fff;    
        border: 1px solid #287947;
        box-shadow: 2px 5px 5px #d4d4d4;
        padding: 7px 10px;
        border-radius: 3px;
        margin: 0;
        margin-bottom: 12px;
        height: 66px;
        display: block;
        line-height: 50px;
        font-size: 18px;
        transition: all .3s ease-in-out;
    }
    .whatsapp-box-link:hover{
        background: #1eb557;
        color: #fff;   
    }
    .youtube-box-link{
        text-align:center;
        background: #e62117;
        color: #fff;    
        border: 1px solid #8e130d;
        box-shadow: 2px 5px 5px #d4d4d4;
        padding: 7px 10px;
        border-radius: 3px;
        margin: 0;
        margin-bottom: 12px;
        height: 66px;
        display: block;
        line-height: 50px;
        font-size: 18px;
        transition: all .3s ease-in-out;
    }
    .youtube-box-link:hover{
        background: #c31b13;
        color: #fff;   
    }
    .blog-box-link{
        text-align:center;
        color: #fff;    
        border: 1px solid #174771;
        box-shadow: 2px 5px 5px #d4d4d4;
        padding: 7px 10px;
        border-radius: 3px;
        margin: 0;
        margin-bottom: 12px;
        height: 66px;
        display: block;
        line-height: 50px;
        font-size: 18px;
        transition: all .3s ease-in-out;
    }
    .blog-box-link:hover{
        color: #fff;   
    }
    .speed-click{
        display: inline-block !important;
        padding: 10px 15px !important;
        margin: 10px 12px;
        box-shadow: 2px 2px 5px #ccc;
        font-weight: bold;
        border-radius: 5px;
    }
    .row-custom .col-custom {
        display: block;
        margin-bottom: 25px;
    }
    .box, .info-box {
        margin-bottom: 13px;
    }
    .ads-slider .item,
    .ads-slider img{
        height: 300px;
    }
    .ads-slider-info{
        position: absolute;
        bottom: 0;
        text-align: center;
        left: 0;
        right: 0;
        background: rgba(0,0,0,.5);
        color: #fff;
    }
    .ads-slider-info h3{
        color: #fff;
    }
    /*.ads-slider.owl-theme .owl-nav{*/
    /*    display: none;*/
    /*}*/
    .ads-slider.owl-theme .owl-dots, .owl-theme .owl-nav {
        margin-bottom: 20px;
        margin-top: 10px;
    }
    
    
    
    
    
    
    
    
    .home-info-box{
        padding: 15px;
        border-radius: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        width: 100%;
    }
    .home-info-box-1{
        background-image: linear-gradient(to left, #0db2de 0%, #005bea 100%) !important;
    }
    .home-info-box-2{
        background-image: linear-gradient(45deg, #f93a5a, #f7778c) !important;
    }
    .home-info-box-3{
        background-image: linear-gradient(to left, #48d6a8 0%, #029666 100%) !important;
    }
    .home-info-box-4{
        background-image: linear-gradient(to left, #efa65f, #f76a2d) !important;
    }
    .home-info-box-5{
        background-image: linear-gradient(to left, #5f71ef, #030885) !important;
    }
    .home-info-box .home-info-box-icon i{
        color: #fff;
        font-size: 26px;
    }
    .home-info-box .home-info-box-content > span{
        display: block;
    }
    .home-info-box .info-box-text{
        color: #fff;
        font-size: 15px;
        margin-bottom: 15px;
    }
    .home-info-box .info-box-number{
        font-size: 22px;
        font-weight: 700;
        color: #fff;
        text-align: center;
    }
    
    .home-tables .box-header{
        padding-bottom: 0 !important;
    }
    .home-tables .box-body{
        padding-top: 0 !important;
    }
    .home-tables .box-header .box-title{
        font-size: 14px !important;
        font-weight: 700;
        color: #242f48 !important;
    }
    .home-tables .box-header .box-title i{
        top: 16px;
        font-size: 14px;
    }
    .home-tables .box-body > div{
        overflow-x: auto
    }
    .home-tables tr{
        display: table;
        width: 100%;
        table-layout: fixed;
    }
    .home-tables .table>thead:first-child>tr:first-child>th{
        font-size: 13px;
        color: #37374e !important;
    }
    .home-tables tbody{
        max-height: 250px;
        overflow: auto;
        display: block;
    }
    .home-tables tr.odd{
        background: #ECF0FA;
    }
    .home-tables .table td{
        font-size: 11px;
        font-weight: 600;
        padding: 10px;
    }
    
    .row.mx-0{
        margin-inline: 0;
    }
    .home-fast-btns{
        margin-top: 20px;
        padding: 15px 8px;
    }
    .home-fast-btns a{
        background: #fff;
        padding: 6px 15px !important;
        font-weight: 600;
        color: #370971;
        border: 1px solid #370971;
        margin: 4px 5px;
        transition: all .2s ease-in;
    }
    /*.home-fast-btns a:nth-of-type(1){*/
    /*    color: #28b97b;*/
    /*    border: 1px solid #28b97b;*/
    /*}*/
    .home-fast-btns a:hover{
        background: #370971;
        color: #fff;
    }
</style>
@extends('layouts.app')
@section('title', __('home.home'))

@section('content')

<!-- Content Header (Page header) -->
<section class="content-header content-header-custom">
    <h1>{{ __('home.welcome_message', ['name' => Session::get('user.first_name')]) }}
    </h1>
</section>

<!-- Main content -->
<section class="content content-custom no-print">
    

    <!--<div class="row">
	    <div class="col-md-4">
	        <div class="whatsapp-box">
	            <a href="https://api.whatsapp.com/send?phone=+201004282491" class="whatsapp-box-link">
	                <i class="fab fa-whatsapp" aria-hidden="true"></i> {{__('lang_v1.contact whatsapp')}}
	           </a>
            </div>
	    </div>
	    <div class="col-md-4">
	        <div class="whatsapp-box">
	            <a href="https://www.youtube.com/playlist?list=PL2A3MD2_15v-w7JumMZsMExgYvHanAvXO" class="youtube-box-link">
	                <i class="fab fa-youtube"></i> {{__('lang_v1.System training videos')}}
	           </a>
            </div>
	    </div>
	    <div class="col-md-4">
	        <div class="blog-box">
	            <a href="https://blog.vowalaa.com" class="blog-box-link bg-primary">
	                <i class="fas fa-book-reader"></i> {{__('lang_v1.blog button')}}
	           </a>
            </div>
	    </div>
    </div>-->
    
    
    <div class="row mx-0">
        <div class="box home-fast-btns">
            @if (auth()->user()->can('product.create')) 
            <a href="{{url('products/create')}}" class="btn">@lang('product.add_product')</a>
            @endif
            @if (auth()->user()->can("purchase.create"))
            <a href="{{url('purchases/create')}}" class="btn">@lang('purchase.add_purchase')</a>
            @endif
            @if (auth()->user()->can('sell.create'))  
            <a href="{{action('SellPosController@create')}}" class="btn">@lang('sale.add_sale')</a>
            @endif
            @if (auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
            <a href="{{url('sellss/search')}}" class="speed-click btn btn-primary">@lang('sale.sells')</a>
            @endif
            
            <a href="{{url('affilate/affilate-products')}}" class="speed-click btn btn-primary">@lang('lang_v1.list_products')</a>
          
        </div>
    </div>
	<div class="row">
		<div class="col-md-12 col-xs-12">
			<div class="btn-group pull-left" data-toggle="buttons">
				<label class="btn btn-info active button4" style="background-color:#f14e4e">
    				<input type="radio" name="date-filter"
    				data-start="{{ date('Y-m-d') }}" 
    				data-end="{{ date('Y-m-d') }}"
    				checked> {{ __('home.today') }}
  				</label>
  				<label class="btn btn-info button4" style="background-color:#f1bb4e">
    				<input type="radio" name="date-filter"
    				data-start="{{ $date_filters['this_week']['start']}}" 
    				data-end="{{ $date_filters['this_week']['end']}}"
    				> {{ __('home.this_week') }}
  				</label>
  				<label class="btn btn-info button4" style="background-color:#4e9af1">
    				<input type="radio" name="date-filter"
    				data-start="{{ $date_filters['this_month']['start']}}" 
    				data-end="{{ $date_filters['this_month']['end']}}"
    				> {{ __('home.this_month') }}
  				</label>
  				<label class="btn btn-info button4" style="background-color:#9a4ef1">
    				<input type="radio" name="date-filter" 
    				data-start="{{ $date_filters['this_fy']['start']}}" 
    				data-end="{{ $date_filters['this_fy']['end']}}" 
    				> {{ __('home.this_fy') }}
  				</label>
  				<label class="btn btn-info button4" style="background-color:#000">
    				<input type="radio" name="date-filter" 
    				data-start="{{ $date_filters['lastfy']}}" 
    				data-end="{{ date('Y-m-d') }}" 
    				> {{ __('home.last_fy') }}
  				</label>
            </div>
		</div>
	</div>

	<div class="row">
	     @if (auth()->user()->can("purchase.create"))
    	<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
	      <div class="home-info-box home-info-box-1">
	        <span class="home-info-box-icon"><i class="ion ion-cash"></i></span>

	        <div class="home-info-box-content">
	          <span class="info-box-text">{{ __('home.total_purchase') }}</span>
	          <span class="info-box-number total_purchase"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    @endif
	    <!-- /.col -->
	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
	      <div class="home-info-box home-info-box-2">
	        <span class="home-info-box-icon"><i class="ion ion-ios-cart-outline"></i></span>

	        <div class="home-info-box-content">
	          <span class="info-box-text">{{ __('home.total_sell_count') }}</span>
	          <span class="info-box-number total_sell"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
	    
	     @if (auth()->user()->can("purchase.create"))
	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
	      <div class="home-info-box home-info-box-3">
	        <span class="home-info-box-icon">
	        	<i class="fa fa-dollar"></i>
				<i class="fa fa-exclamation"></i>
	        </span>

	        <div class="home-info-box-content">
	          <span class="info-box-text">{{ __('home.purchase_due') }}</span>
	          <span class="info-box-number purchase_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
            @endif

	    <!-- fix for small devices only -->
	    <!-- <div class="clearfix visible-sm-block"></div> -->
	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
	      <div class="home-info-box home-info-box-4">
	        <span class="home-info-box-icon">
	        	<i class="ion ion-ios-paper-outline"></i>
	        	<i class="fa fa-exclamation"></i>
	        </span>

	        <div class="home-info-box-content">
	          <span class="info-box-text">{{ __('home.invoice_due') }}</span>
	          <span class="info-box-number invoice_due"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
	      <div class="home-info-box home-info-box-4">
	        <span class="home-info-box-icon">
	        	<i class="ion ion-ios-paper-outline"></i>
	        	<i class="fa fa-exclamation"></i>
	        </span>

	        <div class="home-info-box-content">
	          <span class="info-box-text">{{ __('sale.total_paid') }}</span>
	          <span class="info-box-number total_paid"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
	        </div>
	        <!-- /.info-box-content -->
	      </div>
	      <!-- /.info-box -->
	    </div>
	    <!-- /.col -->
  	<!--</div>-->
  	<!--<div class="row row-custom">-->
        <!-- expense -->
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
          <div class="home-info-box home-info-box-5">
            <span class="home-info-box-icon">
              <i class="fas fa-minus-circle"></i>
            </span>

            <div class="home-info-box-content">
              <span class="info-box-text">
                {{ __('affilate::lang.total_commetion') }}
              </span>
              <span class="info-box-number total_commetion"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            </div>
           
          </div>
        
        </div>
        
         <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
          <div class="home-info-box home-info-box-5">
            <span class="home-info-box-icon">
              <i class="fas fa-minus-circle"></i>
            </span>

            <div class="home-info-box-content">
              <span class="info-box-text">
                {{ __('affilate::lang.total_paids') }}
              </span>
              <span class="info-box-number total_paids"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            </div>
           
          </div>
        
        </div> 
        
        <div class="col-lg-3 col-md-4 col-sm-6 col-xs-12 col-custom">
          <div class="home-info-box home-info-box-5">
            <span class="home-info-box-icon">
              <i class="fas fa-minus-circle"></i>
            </span>

            <div class="home-info-box-content">
              <span class="info-box-text">
                {{ __('affilate::lang.total_remind') }}
              </span>
              <span class="info-box-number total_remind"><i class="fas fa-sync fa-spin fa-fw margin-bottom"></i></span>
            </div>
           
          </div>
        
        </div>
    </div>
    @if(!empty($widgets['after_sale_purchase_totals']))
      @foreach($widgets['after_sale_purchase_totals'] as $widget)
        {!! $widget !!}
      @endforeach
    @endif
    @if(!empty($all_locations))
  	<!-- sales chart start -->
  	<div class="row">
  		<div class="col-sm-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_last_30_days')])
              {!! $sells_chart_1->container() !!}
            @endcomponent
  		</div>
  	</div>
    @endif
    @if(!empty($widgets['after_sales_last_30_days']))
      @foreach($widgets['after_sales_last_30_days'] as $widget)
        {!! $widget !!}
      @endforeach
    @endif
    @if(!empty($all_locations))
  	<div class="row">
  		<div class="col-sm-12">
            @component('components.widget', ['class' => 'box-primary', 'title' => __('home.sells_current_fy')])
              {!! $sells_chart_2->container() !!}
            @endcomponent
  		</div>
  	</div>
    @endif
  	<!-- sales chart end -->
    @if(!empty($widgets['after_sales_current_fy']))
      @foreach($widgets['after_sales_current_fy'] as $widget)
        {!! $widget !!}
      @endforeach
    @endif
  	<!-- products less than alert quntity -->
  	<div class="row">

      <div class="table-responsive col-sm-12 home-tables">
        @component('components.widget', ['class' => 'box-warning'])
          @slot('icon')
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          @endslot
          @slot('title')
            {{ __('lang_v1.sales_payment_dues') }} @show_tooltip(__('lang_v1.tooltip_sales_payment_dues'))
          @endslot
          <table class="table table-bordered" id="sales_payment_dues_table">
            <thead>
              <tr>
                <th>@lang( 'contact.customer' )</th>
                <th>@lang( 'sale.invoice_no' )</th>
                <th>@lang( 'home.due_amount' )</th>
              </tr>
            </thead>
          </table>
        @endcomponent
      </div>
<!--
  		<div class="col-sm-6 home-tables">

        @component('components.widget', ['class' => 'box-warning'])
          @slot('icon')
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          @endslot
          @slot('title')
            {{ __('lang_v1.purchase_payment_dues') }} @show_tooltip(__('tooltip.payment_dues'))
          @endslot
          <table class="table table-bordered" id="purchase_payment_dues_table">
            <thead>
              <tr>
                <th>@lang( 'purchase.supplier' )</th>
                <th>@lang( 'purchase.ref_no' )</th>
                <th>@lang( 'home.due_amount' )</th>
              </tr>
            </thead>
          </table>
        @endcomponent

  		</div>-->
    </div>

    <div class="row">
      
 <!--     <div class="col-sm-6 home-tables">
        @component('components.widget', ['class' => 'box-warning'])
          @slot('icon')
            <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
          @endslot
          @slot('title')
            {{ __('home.product_stock_alert') }} @show_tooltip(__('tooltip.product_stock_alert'))
          @endslot
          <table class="table table-bordered" id="stock_alert_table">
            <thead>
              <tr>
                <th>@lang( 'sale.product' )</th>
                <th>@lang( 'business.location' )</th>
                <th>@lang( 'report.current_stock' )</th>
              </tr>
            </thead>
          </table>
        @endcomponent
      </div>-->
      @can('stock_report.view')
        @if(session('business.enable_product_expiry') == 1)
  <!--        <div class="col-sm-6 home-tables">
              @component('components.widget', ['class' => 'box-warning'])
                  @slot('icon')
                    <i class="fa fa-exclamation-triangle text-yellow" aria-hidden="true"></i>
                  @endslot
                  @slot('title')
                    {{ __('home.stock_expiry_alert') }} @show_tooltip( __('tooltip.stock_expiry_alert', [ 'days' =>session('business.stock_expiry_alert_days', 30) ]) )
                  @endslot
                  <input type="hidden" id="stock_expiry_alert_days" value="{{ \Carbon::now()->addDays(session('business.stock_expiry_alert_days', 30))->format('Y-m-d') }}">
                  <table class="table table-bordered" id="stock_expiry_alert_table">
                    <thead>
                      <tr>
                          <th>@lang('business.product')</th>
                          <th>@lang('business.location')</th>
                          <th>@lang('report.stock_left')</th>
                          <th>@lang('product.expires_in')</th>
                      </tr>
                    </thead>
                  </table>
              @endcomponent
          </div>-->
        @endif
      @endcan
  	</div>

    @if(!empty($widgets['after_dashboard_reports']))
      @foreach($widgets['after_dashboard_reports'] as $widget)
        {!! $widget !!}
      @endforeach
    @endif
</section>
<!-- /.content -->
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

