<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if (auth()->user()->can('journal.show'))
                        <a href="{{action('AccountCategoryController@index')}}" @if(request()->segment(1) == 'account-category' && request()->segment(2) == null) class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-sort-numeric-up-alt me-2"></i> {{__('lang_v1.accounts_guide')}}</a>
                    @endif
                    @if (auth()->user()->can('daily.show'))
                        <a href="{{action('AccountDailyController@index')}}" @if(request()->segment(1) == 'account-daily') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> {{__('sale.daily_restrictions')}}</a>
                    @endif
                    @if (auth()->user()->can('receipt_payment_papers'))
                        <a href="{{action('TransactionPaymentController@index')}}" @if(request()->segment(1) == 'payments') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> {{__('sale.receipt_payment_papers')}}</a>
                    @endif
                    @if (auth()->user()->can('daily.show'))
                        <a href="{{action('AccountDailyController@journalselector')}}" @if(request()->segment(1) == 'journal-selector') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> {{__('sale.journal_selector')}}</a>
                    @endif
                    @if (auth()->user()->can('costs_center.show'))
                        <a href="{{action('CostsCategoryController@index')}}" @if(request()->segment(1) == 'costs-category') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> {{__('sale.costs_center')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        @if (auth()->user()->can('journal_setting'))
        <div class="dropdown nav-dropdown mb-4 me-3">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i> @lang("lang_v1.settings")</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                <a href="{{action('AccountDailyController@journalgetsetting')}}" @if(request()->segment(1) == 'journal-setting') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-calendar-check"></i> {{__('sale.journal_setting')}}</a>
            </div>
        </div>
        @endif
    </div>
</div>