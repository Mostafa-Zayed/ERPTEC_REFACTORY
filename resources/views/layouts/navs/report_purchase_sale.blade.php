<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('purchase_n_sell_report.view'))
                        <a href="{{action('ReportController@purchasePaymentReport')}}" @if(request()->segment(2) == 'purchase-payment-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tasks me-2"></i> @lang('lang_v1.purchase_payment_report')</a>
                        <a href="{{action('ReportController@sellPaymentReport')}}" @if(request()->segment(2) == 'sell-payment-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-search-dollar me-2"></i> @lang('lang_v1.sell_payment_report')</a>
                        <a href="{{route('reports.sell-payment-report2')}}" @if(request()->segment(2) == 'sell-payment-all') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('lang_v1.report_all_sells')</a>
                        <a href="{{action('ReportController@getproductSellReport')}}" @if(request()->segment(2) == 'product-sell-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-arrow-circle-up me-2"></i> @lang('lang_v1.product_sell_report')</a>
                        <a href="{{action('ReportController@getproductPurchaseReport')}}" @if(request()->segment(2) == 'product-purchase-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-arrow-circle-down me-2"></i> @lang('lang_v1.product_purchase_report')</a>
                        <a href="{{action('ReportController@itemsReport')}}" @if(request()->segment(2) == 'items-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tasks me-2"></i> @lang('lang_v1.items_report')</a>
                              @endif
                    @if ((in_array('purchases', $enabled_modules) || in_array('add_sale', $enabled_modules) || in_array('pos_sale', $enabled_modules)) && auth()->user()->can('purchase_n_sell_report.view'))
                        <a href="{{action('ReportController@getPurchaseSell')}}" @if(request()->segment(2) == 'purchase-sell') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-exchange-alt me-2"></i> @lang('report.purchase_sell_report')</a>
                    @endif
                    @if (auth()->user()->can('purchase_n_sell_report.view')) 
                    <a href="{{action('ReportController@getproductStockRelationReport')}}" @if(request()->segment(2) == 'product-stock-relation-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tasks me-2"></i> @lang('lang_v1.product_stock_relation_report')</a>
                      @endif
                </div>
            </div>
        </div>
    </nav>
</div>