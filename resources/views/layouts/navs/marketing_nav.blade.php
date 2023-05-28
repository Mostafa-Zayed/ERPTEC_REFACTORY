<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    @if (auth()->user()->can('sell.view') || auth()->user()->can('sell.create') || auth()->user()->can('direct_sell.access') ||  auth()->user()->can('view_own_sell_only'))
                        @if (auth()->user()->can('discount.access'))
                            <a href="{{action('DiscountController@index')}}"  @if(request()->segment(1) == 'discount') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-percent me-2"></i> {{__('lang_v1.discounts')}}</a>
                        @endif
                    @endif
                    @if (in_array('coupons', $enabled_modules))
                        @if (auth()->user()->can('coupons.view'))
                            <a href="{{action('CouponController@index')}}"  @if(request()->segment(1) == 'coupons') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-gifts me-2"></i> {{__('lang_v1.coupons')}}</a>
                        @endif
                    @endif
                    @if (in_array('marketing', $enabled_modules))
                        @if (auth()->user()->can('role.traficResource') )
                            <a href="{{action('TraficController@index')}}"  @if(request()->segment(1) == 'trafic') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-route me-2"></i> {{__('sale.Trafic_resourse')}}</a>
                        @endif
                        @if (auth()->user()->can('role.Campaigns') )
                            <a href="{{action('CampaignController@index')}}"  @if(request()->segment(1) == 'campaign') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-map-signs me-2"></i> {{__('sale.campaigns')}}</a>
                        @endif
                    @endif 
                     <!--  @if (auth()->user()->can('role.Campaigns') )
                            <a href="{{action('TransactionTypeController@index')}}"  @if(request()->segment(1) == 'transaction-types') class="active-dark nav-link" @else class="nav-link" @endif><i class="fas fa-map-signs me-2"></i> {{__('sale.trans_types')}}</a>
                        @endif-->
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