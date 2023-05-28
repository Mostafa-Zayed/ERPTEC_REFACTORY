<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if (auth()->user()->can('purchase_n_sell_report.view'))
                        <a href="{{action('ReportController@purchasePaymentReport')}}" 
                        @if(request()->segment(2) == 'purchase-payment-report' || request()->segment(2) == 'sell-payment-report' || request()->segment(2) == 'product-sell-report'
                        || request()->segment(2) == 'product-purchase-report' || request()->segment(2) == 'items-report' || request()->segment(2) == 'purchase-sell' || request()->segment(2) == 'sell-payment-all') 
                            class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-tasks me-2"></i> @lang("lang_v1.sales_purchases_reports")</a>
                    @endif
                    @if ( in_array('customer_dues_report', $enabled_modules))
                        @if (auth()->user()->can('customer_dues_report'))
                            <a href="{{action('ReportController@customer_dues_report')}}" 
                            @if(request()->segment(2) == 'customer-dues-report' || request()->segment(2) == 'customer-group' || request()->segment(2) == 'customer-supplier') 
                                class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang("lang_v1.customers_suppliers_reports")</a>
                        @endif
                    @endif
                    @if ( in_array('report_courier', $enabled_modules))
                        @if (auth()->user()->can('report_courier'))
                            <a href="{{action('SellCompanyController@report_courier')}}" 
                            @if(request()->segment(2) == 'report-courier' || request()->segment(2) == 'shipping-status' || request()->segment(2) == 'orderstatus' || request()->segment(2) == 'shipstatus'
                        || request()->segment(2) == 'paystatus' || request()->segment(2) == 'carrierlog' || request()->segment(2) == 'carrier-account') 
                                class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang("lang_v1.shipping_reports")</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('stock_report.view'))
                        <a href="{{action('ReportController@getStockReport')}}" 
                        @if(request()->segment(2) == 'stock-report' || request()->segment(2) == 'lot-report' || request()->segment(2) == 'product-items-report' ||
                        request()->segment(2) == 'stock-adjustment-report' || request()->segment(2) == 'stock-adjustment' || request()->segment(2) == 'stock-expiry' ||
                        request()->segment(2) == 'imei-report' || request()->segment(2) == 'product-delete-report' || (request()->segment(2) == 'stock-transfer' && request()->segment(4) == 'report')  || 
                        request()->segment(2) == 'all-product-sell-report' || request()->segment(2) == 'trending-products' || request()->segment(2) == 'product_stock_need') 
                            class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-hourglass-half me-2"></i> @lang("lang_v1.products_reports")</a>
                    @endif
                    @if (auth()->user()->can('delegate_dues'))
                        <a href="{{action('ReportController@delegate_dues')}}" 
                        @if(request()->segment(2) == 'delegate-dues' || request()->segment(2) == 'user-sell-report' || request()->segment(2) == 'user-report' ||
                        request()->segment(2) == 'sales-representative-report' || request()->segment(2) == 'register-report') 
                            class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-users me-2"></i> @lang("lang_v1.employees_reports")</a>
                    @endif
                    @if (auth()->user()->can('profit_loss_report.view'))
                        <a href="{{action('ReportController@getProfitLoss')}}" 
                        @if(request()->segment(2) == 'profit-loss' || request()->segment(2) == 'profit-loss' || request()->segment(2) == 'profit-report' || request()->segment(2) == 'expense-report' || 
                        request()->segment(2) == 'tax-report' || request()->segment(2) == 'table-report' || request()->segment(2) == 'trafic-report' || request()->segment(2) == 'income-list') 
                            class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang("lang_v1.other_reports")</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <!--<div class="dropdown nav-dropdown mb-4">-->
    <!--    <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">-->
    <!--        <span><i class="fas fa-cog"></i> Settings</span>-->
    <!--    </button>-->
    <!--    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">-->
    <!--        <a class="dropdown-item" href="#">1</a>-->
    <!--        <a class="dropdown-item" href="#">2</a>-->
    <!--    </div>-->
    <!--</div>-->
</div>