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
                <a class="navbar-brand" href="{{route('shop.index')}}"><i class="fa fas fa-users"></i> {{__('shop::lang.shop_module')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style="flex-direction: row;">
                    @can(auth()->user()->can('shop.access_api_settings'))
                        <li @if(request()->segment(2) == 'settings') class="active" @endif><a href="{{route('shop.settings')}}">@lang('shop::lang.settings')</a></li>
                    @endcan
                    
                    @can(auth()->user()->can('shop.show_sync'))
                        <li @if(request()->segment(2) == 'sync') class="active" @endif><a href="{{route('shop.sync')}}">@lang('shop::lang.show_sync')</a></li>
                    @endcan
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>