<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('delegate_dues'))
                        <a href="{{action('ReportController@delegate_dues')}}" @if(request()->segment(2) == 'delegate-dues') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('lang_v1.delegate_dues')</a>
                    @endif
                    @if ( in_array('sale_sell_report', $enabled_modules))
                        @if (auth()->user()->can('sale_sell_report'))
                            <a href="{{action('ReportController@AllSellReport')}}" @if(request()->segment(2) == 'user-sell-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-users me-2"></i> @lang('lang_v1.sale_sell_report')</a>
                        @endif
                    @endif
                    @if ( in_array('user_sell_report', $enabled_modules))
                        @if (auth()->user()->can('user_sell_report'))
                            <a href="{{action('ReportController@user_status')}}" @if(request()->segment(2) == 'user-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user me-2"></i> @lang('report.user_sell_report')</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('sales_representative.view'))
                        <a href="{{action('ReportController@getSalesRepresentativeReport')}}" @if(request()->segment(2) == 'sales-representative-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-users me-2"></i> @lang('report.sales_representative')</a>
                    @endif
                    @if (auth()->user()->can('register_report.view'))
                        <a href="{{action('ReportController@getRegisterReport')}}" @if(request()->segment(2) == 'register-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-briefcase me-2"></i> @lang('report.register_report')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>