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
                <a class="navbar-brand" href="{{route('shipment.index')}}"><i class="fa fas fa-users"></i> {{__('shipment::lang.shipment')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style="flex-direction: row;">
                    @can('essentials.crud_leave_type')
                        <li @if(request()->segment(2) == 'company') class="active" @endif><a href="{{route('shipment.company')}}">@lang('shipment::lang.company')</a></li>
                    @endcan
                    @if(auth()->user()->can('essentials.crud_all_leave') || auth()->user()->can('essentials.crud_own_leave'))
                        <li @if(request()->segment(2) == 'accounts') class="active" @endif><a href="{{route('shipment.accounts')}}">@lang('shipment::lang.account')</a></li>
                    @endif
                        <li @if(request()->segment(2) == 'zones' && request()->segment(3) != 'price') class="active" @endif>
                            <a href="{{route('shipment.zones.index')}}">@lang('shipment::lang.zones')</a>
                        </li>
                        <li @if(request()->segment(3) == 'price') class="active" @endif>
                            <a href="{{route('shipment.zones.price')}}">@lang('shipment::lang.zone_price')</a>
                        </li>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>