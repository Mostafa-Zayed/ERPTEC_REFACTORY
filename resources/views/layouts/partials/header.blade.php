@inject('request', 'Illuminate\Http\Request')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous">
<!-- Main Header -->
<!--tag manager here-->
<script src="https://kit.fontawesome.com/294faa75f4.js" crossorigin="anonymous"></script>

  <header class="main-header no-print">
    <!-- Start New Navbar -->
    <div class="main-top-nav d-flex align-items-start align-items-md-center justify-content-md-between flex-column flex-md-row">
        
        <!-- Start Right Side -->
        <div class="d-flex align-items-center justify-content-between top-nav-logo"> 
            <div class="sidebar-btn mx-2">
                <img src="{{asset('new_assets/images/elements-icons-menu.svg')}}" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            </div>
            <!-- Start Subscribtion Plan Info -->
            
            @if(Module::has('Superadmin'))
                
                @includeIf('superadmin::layouts.partials.active_subscription')
            @endif
            <!-- End Subscribtion Plan -->
            
            <!-- Start Attendance Registeration -->
	        @if(Module::has('Essentials'))
                @includeIf('essentials::layouts.partials.header_part')
            @endif
	        <!-- End Attendance Registeration -->
	        
	        <!-- Start Languages -->
	        @php
                $config_languages = config('constants.langs');
                $languages = [];
                foreach ($config_languages as $key => $value) {
                    $languages[$key] = $value['full_name'];
                }
                $user_id  = request()->session()->get('user.id');
                $usr  =  App\User::where('id', $user_id)->first();
            @endphp
            <select name="language" class="lang language selectors ">
                @foreach($languages as $key=>$language) 
                    <option value="{{route('home.lang',$key)}}"  {{!empty($usr->language)  ?  ($usr->language == $key)  ? "selected" : ""   : ""}}>{{$language}}</option>
                @endforeach
            </select>
            <!-- End Languages -->
            
            <!-- Clear Cache -->
            <a href="{{ route('cache-clear') }}" class="icon-container d-flex align-items-center justify-content-center" title="@lang('lang_v1.clear_cache')" data-toggle="tooltip" data-placement="bottom">
                <i class="fas fa-broom"></i>
            </a>
        </div>
        <!-- End Right Side -->
        
        <!-- Start Left Side -->
        <div class="d-flex align-items-center">
            
            <!-- Start Register Details -->
            {{-- @if($request->segment(1) == 'pos')
                <button type="button" id="register_details" class="icon-container d-flex align-items-center justify-content-center"  
                    title="{{ __('cash_register.register_details') }}" data-toggle="tooltip" data-placement="bottom" data-container=".register_details_modal" data-href="{{ action('CashRegisterController@getRegisterDetails')}}">
                    <i class="fa fa-briefcase fa-lg" aria-hidden="true"></i>
                </button>
                <button type="button" id="close_register" class="icon-container d-flex align-items-center justify-content-center"  
                    title="{{ __('cash_register.close_register') }}" data-toggle="tooltip" data-placement="bottom" data-container=".close_register_modal" data-href="{{ action('CashRegisterController@getCloseRegister')}}">
                    <i class="fa fa-window-close fa-lg"></i>
                </button>
            @endif --}}
            <!-- End Register Details -->
            
            <!-- Start Sale POS -->
            @if( auth()->user()->can('superadmin'))
                @if(in_array('pos_sale', $enabled_modules))
                    @can('sell.create')
                        <a href="{{action('SellPosController@create')}}" class="icon-container d-flex align-items-center justify-content-center" 
                            title="@lang('sale.pos_sale')" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left hidden-xs btn-sm">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    @endcan
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
                        @if(!empty($pack['custom_permissions']['online_module'])) 
                            @if($pack['custom_permissions']['online_module'] == 1 ) 
                                @if(in_array('pos_sale', $enabled_modules))
                                    @can('sell.create')
                                        <a href="{{action('SellPosController@create')}}" class="icon-container d-flex align-items-center justify-content-center"
                                            title="@lang('sale.pos_sale')" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    @endcan
                                @endif  
                            @endif  
                        @endif  
                    @endif  
                @endif
            @endif
            <!-- End Sale POS -->
            
            <!-- Start Retail Sale POS -->
            @if(in_array('pos_sale', $enabled_modules))
                @can(['retail.create','retail.view'])
                {{--
                    <a href="{{action('SellPosController2@create')}}" class="icon-container d-flex align-items-center justify-content-center"
                        title="@lang('sale.pos_sale2')" data-toggle="tooltip" data-placement="bottom">
                      <i class="fas fa-store-alt"></i>
                    </a>
                --}}    
                @endcan
            @endif
            <!-- End Retail Sale POS -->
            
            @include('layouts.partials.header-notifications')
            <div class="separator"></div>
            <div class="dropdown" style="margin-left:5px;">
                <button class="dropdown-toggle profile-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                    @if(!empty(Session::get('business.logo')))
                        <img src="{{ url( 'public/uploads/business_logos/' . Session::get('business.logo') ) }}" class="avatar">
                    @endif
                    <span>{{ Auth::User()->first_name }}</span>
                </button>    
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href="{{action('UserController@getProfile')}}">@lang('lang_v1.profile')</a>
                    <a class="dropdown-item" href="{{action('Auth\LoginController@logout')}}">@lang('lang_v1.sign_out')</a>
                </div>
            </div>        
        </div>    
    </div>      
    <!-- End New Navbar -->  
  </header>