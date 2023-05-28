<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-2">
                <div class="navbar-nav">
                    @if( auth()->user()->can('superadmin'))
                        @if (in_array('kitchen', $enabled_modules))
                            <a href="{{action('Restaurant\KitchenController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'kitchen') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-fire me-2"></i> @lang('restaurant.kitchen')</a>
                            <a href="{{action('Restaurant\OrderController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'orders') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-list-alt me-2"></i> @lang('restaurant.orders')</a>
                        @endif
                        @if (in_array('booking', $enabled_modules) && (auth()->user()->can('crud_all_bookings') || auth()->user()->can('crud_own_bookings')))
                            <a href="{{action('Restaurant\BookingController@index')}}" @if(request()->segment(1) == 'bookings') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> @lang('restaurant.bookings')</a>
                        @endif
                    @else
                        @php
                            $business_id = request()->session()->get('user.business_id');
                            $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);
                        @endphp
                        @if (!empty($package))
                            @php
                                $pack  = \Modules\Superadmin\Entities\Package::where('id',$package->package_id)->first();
                            @endphp
                            @if (!empty($pack))
                                @if(!empty($pack['custom_permissions']['restaurant_module']))
                                    @if($pack['custom_permissions']['restaurant_module'] == 1 )
                                        @if (in_array('kitchen', $enabled_modules) && (auth()->user()->can('restaurant.kitchen') || auth()->user()->can('restaurant.orders') ) )
                                            @if( auth()->user()->can('restaurant.kitchen'))
                                                <a href="{{action('Restaurant\KitchenController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'kitchen') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-fire me-2"></i> @lang('restaurant.kitchen')</a>
                                            @endif
                                            @if( auth()->user()->can('restaurant.orders'))
                                                <a href="{{action('Restaurant\OrderController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'orders') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-list-alt me-2"></i> @lang('restaurant.orders')</a>
                                            @endif
                                        @endif
                                        @if (in_array('booking', $enabled_modules) && (auth()->user()->can('crud_all_bookings') || auth()->user()->can('crud_own_bookings')))
                                            <a href="{{action('Restaurant\BookingController@index')}}" @if(request()->segment(1) == 'bookings') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-calendar-check me-2"></i> @lang('restaurant.bookings')</a>
                                        @endif
                                    @endif
                                @endif
                            @endif
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </nav>
    <div class="dropdown nav-dropdown mb-4">
        <button class="dropdown-toggle profile-toggle px-4" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
            <span><i class="fas fa-cog"></i> إعدادات المطعم</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
            @if (in_array('tables', $enabled_modules) && auth()->user()->can('business_settings.create'))
                <a href="{{action('Restaurant\TableController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'tables') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-table"></i> {{__('restaurant.tables')}}</a>
            @endif
            @if (in_array('modifiers', $enabled_modules) && (auth()->user()->can('product.view') || auth()->user()->can('product.create')))
                <a href="{{action('Restaurant\ModifierSetsController@index')}}" @if(request()->segment(1) == 'modules' && request()->segment(2) == 'modifiers') class="active-light dropdown-item" @else class="dropdown-item" @endif><i class="fas fa-pizza-slice"></i> {{__('restaurant.modifiers')}}</a>
            @endif
        </div>
    </div>
</div>