<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if(auth()->user()->can('account.access'))
                        <a href="{{action('AccountController@index')}}" @if(request()->segment(1) == 'account' && request()->segment(2) == 'account') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-list me-2"></i> {{__('account.list_accounts')}}</a>
                    @endif
                    @if (in_array('expenses', $enabled_modules) && auth()->user()->can('expense.access'))
                        <a href="{{action('ExpenseController@index')}}" @if(request()->segment(1) == 'expenses' && request()->segment(2) == null) class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-list me-2"></i> {{__('lang_v1.list_expenses')}}</a>
                    @endif
                    @if(auth()->user()->can('account.payment_account_report'))
                        <a href="{{action('AccountReportsController@paymentAccountReport')}}" @if(request()->segment(1) == 'account' && request()->segment(2) == 'payment-account-report') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-file-alt me-2"></i> {{__('account.payment_account_report')}}</a>
                    @endif
                    @if(auth()->user()->can('account.cash_flow'))
                        <a href="{{action('AccountController@cashFlow')}}" @if(request()->segment(1) == 'account' && request()->segment(2) == 'cash-flow') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-exchange-alt me-2"></i> {{__('lang_v1.cash_flow')}}</a>
                    @endif
                    @if(auth()->user()->can('account.balance_sheet'))
                        <a href="{{action('AccountReportsController@balanceSheet')}}" @if(request()->segment(1) == 'account' && request()->segment(2) == 'balance-sheet') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-book me-2"></i> {{__('account.balance_sheet')}}</a>
                    @endif
                    @if(auth()->user()->can('account.trial_balance'))
                        <a href="{{action('AccountReportsController@trialBalance')}}" @if(request()->segment(1) == 'account' && request()->segment(2) == 'trial-balance') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-balance-scale me-2"></i> {{__('account.trial_balance')}}</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="d-flex">
        @if (in_array('expenses', $enabled_modules) && auth()->user()->can('expense.access'))
            <div class="dropdown nav-dropdown mb-4 me-3">
                <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                    <span><i class="fas fa-cog"></i> @lang("lang_v1.settings")</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a href="{{action('ExpenseCategoryController@index')}}" @if(request()->segment(1) == 'expense-categories') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-calendar-check"></i> {{__('expense.expense_categories')}}</a>
                </div>
            </div>
        @endif
    </div>
</div>