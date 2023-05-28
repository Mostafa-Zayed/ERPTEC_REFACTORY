<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if ( in_array('report_courier', $enabled_modules))
                        @if (auth()->user()->can('report_courier'))
                            <a href="{{action('SellCompanyController@report_courier')}}" @if(request()->segment(2) == 'report-courier') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('report.shipments')</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('shipping_cost'))
                        <a href="{{action('SellController@shipping_cost')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'shipping-cost') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tag me-2"></i> @lang('sale.shipping_cost')</a>
                    @endif
                    @if ( in_array('shipment_report', $enabled_modules))
                        @if (auth()->user()->can('shipment_report'))
                            <a href="{{action('ReportController@shipping_status')}}" @if(request()->segment(2) == 'shipping-status') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('report.shipment_report')</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('access_shipping') )
                        @if (in_array('order_status', $enabled_modules))
                            <a href="{{action('SellController@orderstatus')}}" @if(request()->segment(2) == 'orderstatus') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tags me-2"></i> @lang('lang_v1.order_statuss')</a>
                        @endif
                        @if (in_array('shipping_status', $enabled_modules))
                            <a href="{{action('SellController@shipstatus')}}" @if(request()->segment(2) == 'shipstatus') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tags me-2"></i> @lang('lang_v1.shipping_status')</a>
                        @endif
                        <a href="{{action('SellController@paystatus')}}" @if(request()->segment(2) == 'paystatus') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tags me-2"></i> @lang('lang_v1.payment_status')</a>
                        <a href="{{action('SellController@carrierlog')}}" @if(request()->segment(2) == 'carrierlog') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-tags me-2"></i> @lang('sale.carrierlogs')</a>
                    @endif
                    @if (in_array('carrier_accounts', $enabled_modules))
                        @if(auth()->user()->can('carrier.account') || auth()->user()->can('carrier.agent'))
                            <a href="{{action('SellController@carrieraccounts')}}" @if(request()->segment(2) == 'carrier-account') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('account.carrier_accounts')</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>