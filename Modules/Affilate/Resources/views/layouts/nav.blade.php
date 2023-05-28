<div class="d-flex align-items-top justify-content-between no-print">
    <nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav">
        <div class="container-fluid p-0">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fas fa-list"></i>
            </button>
            <div class="collapse navbar-collapse px-0 mx-0" id="bs-example-navbar-collapse-1">
                <div class="navbar-nav">
                    <a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@index')}}" @if(request()->segment(1) == 'affilate' && request()->segment(2) == null) class="active-dark nav-link" @else class="nav-link" @endif>{{__('affilate::lang.affilate')}}</a>
                    @if (auth()->user()->can('affilate.affilate_log'))
                        <a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewSyncLog')}}" @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'view-sync-log') class="active-dark nav-link" @else class="nav-link" @endif>@lang('affilate::lang.affilate_log')</a>
                    @endif
                    @if (auth()->user()->can('affilate.access_affilate_balance'))
                        <a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewbalance')}}" @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'balance-log') class="active-dark nav-link" @else class="nav-link" @endif>@lang('affilate::lang.balance')</a>
                    @endif
                    @if (auth()->user()->can('affilate.affilate_paids_show'))
                        <a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewpaids')}}" @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'paids-log') class="active-dark nav-link" @else class="nav-link" @endif>@lang('affilate::lang.paids')</a>
                    @endif  
                    
                    @if (auth()->user()->can('affilate.affilate_report_show'))
                        <a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@reports')}}" @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'report') class="active-dark nav-link" @else class="nav-link" @endif>@lang('affilate::lang.affilate_report')</a>
                    @endif
                </div>
            </div>
        </div>
    </nav>
</div>
{{--
<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@index')}}"><i class="fab fa-autoprefixer"></i> {{__('affilate::lang.affilate')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    
                   @if (auth()->user()->can('affilate.affilate_log'))
                    <li @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'view-sync-log') class="active" @endif><a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewSyncLog')}}">@lang('affilate::lang.affilate_log')</a></li>
                    @endif
                   @if (auth()->user()->can('affilate.access_affilate_balance'))
                    <li @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'balance-log') class="active" @endif><a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewbalance')}}">@lang('affilate::lang.balance')</a></li>
                    @endif
                  @if (auth()->user()->can('affilate.affilate_paids_show'))
                    <li @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'paids-log') class="active" @endif><a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@viewpaids')}}">@lang('affilate::lang.paids')</a></li>
                    @endif
                    @if (auth()->user()->can('affilate.affilate_report_show'))
                    <li @if(request()->segment(1) == 'affilate' && request()->segment(2) == 'report') class="active" @endif><a href="{{action('\Modules\Affilate\Http\Controllers\AffilateController@reports')}}">@lang('affilate::lang.paids')</a></li>
                    @endif
                 
                        
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>
--}}