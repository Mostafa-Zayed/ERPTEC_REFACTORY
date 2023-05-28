<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('profit_loss_report.view'))
                        <a href="{{action('ReportController@getProfitLoss')}}" @if(request()->segment(2) == 'profit-loss') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('report.profit_loss')</a>
                    @endif
                    @if (auth()->user()->can('profit_report'))
                        <a href="{{action('ReportController@profit_report')}}" @if(request()->segment(2) == 'profit-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('report.profit_report')</a>
                    @endif
                    @if (in_array('expenses', $enabled_modules) && auth()->user()->can('expense_report.view'))
                        <a href="{{action('ReportController@getExpenseReport')}}" @if(request()->segment(2) == 'expense-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-search-minus me-2"></i> @lang('report.expense_report')</a>
                    @endif
                    @if (auth()->user()->can('tax_report.view'))
                        <a href="{{action('ReportController@getTaxReport')}}" @if(request()->segment(2) == 'tax-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-percent me-2"></i> @lang('report.tax_report')</a>
                    @endif
                    @if (auth()->user()->can('purchase_n_sell_report.view') && in_array('tables', $enabled_modules))
                        <a href="{{action('ReportController@getTableReport')}}" @if(request()->segment(2) == 'table-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-table me-2"></i> @lang('restaurant.table_report')</a>
                    @endif 
                    {{--
                    @if (auth()->user()->can('income_statement'))
                        <a href="{{action('ReportController@income_statement')}}" @if(request()->segment(2) == 'income_statement') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-table me-2"></i> @lang('report.income_statement')</a>
                    @endif
                    --}}
                     @if (auth()->user()->can('profit_report'))
                        <a href="{{action('ReportController@product_profit')}}" @if(request()->segment(2) == 'product_profit_report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('report.product_profit')</a>
                    @endif 
                    
                    @if (auth()->user()->can('role.trafic_resources'))
                        <a href="{{action('ReportController@getTraficReport')}}" @if(request()->segment(2) == 'trafic-report') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-invoice-dollar me-2"></i> @lang('report.trafic_resources')</a>
                    @endif
                       @if (auth()->user()->can('income_statement'))
                        <a href="{{action('ReportController@getIncomeList')}}" @if(request()->segment(2) == 'income-list') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-table me-2"></i> @lang('report.income_list')</a>
                    @endif
                    
                    @if (auth()->user()->can('income_statement'))
                        <a href="{{action('ReportController@getbalancesheet')}}" @if(request()->segment(2) == 'balance-sheet') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-table me-2"></i> @lang('report.balance_sheet')</a>
                    @endif   
                    
                    @if (auth()->user()->can('income_statement'))
                        <a href="{{action('ReportController@gettrialBalance')}}" @if(request()->segment(2) == 'trial-balance') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-table me-2"></i> @lang('report.trial_balance')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>