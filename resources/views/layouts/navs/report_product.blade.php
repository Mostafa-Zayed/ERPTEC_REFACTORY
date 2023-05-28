<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('stock_report.view'))
                        <a href="{{action('ReportController@getStockReport')}}" @if(request()->segment(2) == 'stock-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-hourglass-half me-2"></i> @lang('report.stock_report')</a>
                        @if (session('business.enable_lot_number') == 1)    
                            <a href="{{action('ReportController@getLotReport')}}" @if(request()->segment(2) == 'lot-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-hourglass-half me-2"></i> @lang('lang_v1.lot_report')</a>
                        @endif
                        <a href="{{action('ReportController@productitemsReport')}}" @if(request()->segment(2) == 'product-items-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-hourglass-half me-2"></i> @lang('home.product_stock_alert')</a>
                        @if (in_array('stock_adjustment', $enabled_modules))
                            <a href="{{action('ReportController@getStockAdjustmentReport')}}" @if(request()->segment(2) == 'stock-adjustment-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-sliders-h me-2"></i> @lang('report.stock_adjustment_report')</a>
                        @endif
                        @if (in_array('stock_adjustment', $enabled_modules))
                            <a href="{{action('ReportController@getStockAdjustmentProductReport')}}" @if(request()->segment(2) == 'stock-adjustment') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('stock_adjustment.stock_adjustment_product_report')</a>
                        @endif
                        @if (session('business.enable_product_expiry') == 1)
                            <a href="{{action('ReportController@getStockExpiryReport')}}" @if(request()->segment(2) == 'stock-expiry') class="active nav-link" @else class="nav-link" @endif><i class="far fa-calendar-alt me-2"></i> @lang('report.stock_expiry_report')</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('purchase_n_sell_report.view'))
                        <a href="{{action('ReportController@getImeiSerialReport')}}" @if(request()->segment(2) == 'imei-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-arrow-circle-up me-2"></i> @lang('lang_v1.imei_report')</a>
                        <a href="{{action('ReportController@getproductDeleteReport')}}" @if(request()->segment(2) == 'product-delete-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-recycle me-2"></i> @lang('lang_v1.product_delete_report')</a>
                    @endif
                    <a href="{{action('ReportController@getStockTransferProductReport')}}" @if(request()->segment(2) == 'stock-transfer' && request()->segment(4) == 'report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('stock_adjustment.stock_transfer_product_report')</a>
                    @if (auth()->user()->can('opennig_stock_report'))
                        <a href="{{action('ReportController@getproductOpeningStockReport')}}" @if(request()->segment(2) == 'opennig-stock-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-arrow-circle-up me-2"></i> @lang('lang_v1.opening_stock_report')</a>
                    @endif
                    @if (auth()->user()->can('purchase_n_sell_report.view'))
                        <a href="{{action('ReportController@getAllproductAdvancedSellReport')}}" @if(request()->segment(2) == 'all-product-sell-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-arrow-circle-up me-2"></i> @lang('lang_v1.all_product_sell_report')</a>
                    @endif
                    @if (auth()->user()->can('trending_product_report.view'))
                        <a href="{{action('ReportController@getTrendingProducts')}}" @if(request()->segment(2) == 'trending-products') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-chart-line me-2"></i> @lang('report.trending_products')</a>
                    @endif 
                    
                    @if (auth()->user()->can('stock_report.view'))
                        <a href="{{action('ReportController@product_stock_need')}}" @if(request()->segment(2) == 'product_stock_need') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-chart-line me-2"></i> @lang('report.product_stock_need')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>