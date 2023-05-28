<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav no-print">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if (auth()->user()->can('direct_sell.access') ||  auth()->user()->can('retail.view'))
                        <a href="{{action('SellController@index_retailer')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'retail' && !request()->segment(3)) class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-archive me-2"></i> {{__('sale.sells_retail')}}</a>
                        <a href="{{action('SellController@indexretaildone')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'retail' && request()->segment(3) == 'done') class="active nav-link" @else class="nav-link" @endif><i class="far fa-check-square me-2"></i> {{__('sale.all_sales_retail_done')}}</a>
                        @if (auth()->user()->can('sell_return'))
                            <a href="{{action('SellReturnController@index_retail')}}" @if(request()->segment(1) == 'sell-return' && request()->segment(2) == 'all' && request()->segment(3) == 'retail') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-undo me-2"></i> {{__('sale.list_sell_retail_return')}}</a>
                        @endif
                    @endif
                    @if (auth()->user()->can('retail.create'))
                        @if (in_array('pos_sale', $enabled_modules))
                            <a href="{{action('SellController@getRetailDrafts')}}" @if(request()->segment(1) == 'sells' && request()->segment(2) == 'retail' && request()->segment(3) == 'drafts') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-pen-square me-2"></i> {{__('lang_v1.list_drafts')}}</a>
                            <a href="{{action('SellController@getRetailQuotations')}}" @if(request()->segment(1) == 'sells' && request()->segment(2) == 'retail' && request()->segment(3) == 'quotations') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-clipboard-list me-2"></i> {{__('lang_v1.list_quotations')}}</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>
    {{--
    <div class="d-flex">
        <div class="dropdown nav-dropdown mb-4 me-3">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-cog"></i> @lang("lang_v1.settings")</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                @if (auth()->user()->can('sell.create'))
                    <a href="{{action('ImportSalesController@index')}}" @if(request()->segment(1) == 'import-sales') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-download"></i> {{__('lang_v1.import_sales')}}</a>
                @endif
                @if (auth()->user()->can('list_quotations'))
                    <a href="{{action('SellController@getQuotations')}}" @if(request()->segment(1) == 'sells' && request()->segment(2) == 'quotations') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-clipboard-list"></i>  {{__('lang_v1.list_quotations')}}</a>
                @endif    
                @if(auth()->user()->can('sell.view'))
                    @if (auth()->user()->can('sell_return'))
                        <a href="{{action('SellReturnController@index')}}" @if(request()->segment(1) == 'sell-return' && request()->segment(2) == null) class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-undo"></i> {{__('lang_v1.list_sell_return')}}</a>
                    @endif
                @endif
                @if (auth()->user()->can('sell.view') || auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                    @if (auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                        <a href="{{action('SellController@indexcancel')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'cancel') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-ban"></i> {{__('lang_v1.all_sales_cancel')}}</a>
                        <a href="{{action('SellController@indexdone')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'done') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="far fa-check-square"></i> {{__('lang_v1.all_sales_done')}}</a>
                    @endif
                @endif
            </div>
        </div>
        <div class="dropdown nav-dropdown mb-4">
            <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-expanded="false">
                <span><i class="fas fa-search"></i> @lang('lang_v1.search')</span>
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                <a href="{{action('SearchSellController@search')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'search') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-search"></i> @lang('lang_v1.search')</a>
                <!-- Hash Next Line-->
                <a @if(request()->segment(3) == 'all-sells') class="active-light dropdown-item" @else class="dropdown-item" @endif href="{{action('SellStepController@index_all')}}"><i class="fas fa-search"></i>@lang('sale.search_all_sell')</a>
                @if (auth()->user()->can('sell.view') || auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                    @if (auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                        <a href="{{action('SellController@import_index')}}" @if(request()->segment(1) == 'sellss' && request()->segment(2) == 'import') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-search"></i> {{__('lang_v1.filter_sells_by_sheet')}}</a>
                    @endif
                @endif
            </div>
        </div>
    </div>
    --}}
</div>