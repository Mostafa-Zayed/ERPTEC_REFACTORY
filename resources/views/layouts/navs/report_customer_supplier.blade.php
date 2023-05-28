<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if ( in_array('customer_dues_report', $enabled_modules))
                        @if (auth()->user()->can('customer_dues_report'))
                            <a href="{{action('ReportController@customer_dues_report')}}" @if(request()->segment(2) == 'customer-dues-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-user-secret me-2"></i> @lang('sale.customer_dues_report')</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('contacts_report.view'))
                        <a href="{{action('ReportController@getCustomerGroup')}}" @if(request()->segment(2) == 'customer-group') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-users me-2"></i> @lang('lang_v1.customer_groups_report')</a>
                        <a href="{{action('ReportController@getCustomerSuppliers')}}" @if(request()->segment(2) == 'customer-supplier') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-address-book me-2"></i> @lang('report.contacts')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>