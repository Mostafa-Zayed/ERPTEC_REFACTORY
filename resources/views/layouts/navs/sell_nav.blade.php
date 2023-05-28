<nav class="navbar navbar-expand-lg bg-white mb-4 p-0 inner-nav no-print">
    <div class="container-fluid p-0">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-2" aria-expanded="false">
            <i class="fas fa-list"></i>
        </button>
        <div class="collapse navbar-collapse px-0" id="bs-example-navbar-collapse-2">
            <div class="navbar-nav">
                <a @if(request()->segment(1) == 'sells') class="active nav-link" @else class="nav-link" @endif href="{{action('SellController@index')}}"><i class="fa fas fa-dollar-sign"></i> {{__('sale.sells')}}</a>
                <a href="{{action('SearchSellController@search')}}" @if(request()->segment(2) == 'search') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-search me-2"></i> @lang('lang_v1.search')</a>
                <a href="{{action('SellController@index_confirm')}}"  @if(request()->segment(3) == 'confirmed') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-alt me-2"></i> @lang('sale.index_confirm')</a>
                <a href="{{action('SellController@index_ready')}}" @if(request()->segment(3) == 'ready') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-truck-loading me-2"></i> @lang('sale.warehouse')</a>
                <a href="{{action('SellController@index_review')}}" @if(request()->segment(3) == 'review') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-truck me-2"></i> @lang('sale.To_ship')</a>
                <a href="{{action('SellController@index_recieve')}}" @if(request()->segment(3) == 'recieved') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-thumbtack me-2"></i> @lang('sale.Out_for_delivery')</a>
                <a href="{{action('SellController@index_delivered')}}" @if(request()->segment(3) == 'delivered') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-file-signature me-2"></i> @lang('sale.delivered')</a>
                <a href="{{action('SellController@return_recieve')}}" @if(request()->segment(3) == 'return') class="active nav-link" @else class="nav-link" @endif><i class="fas fa-undo me-2"></i> @lang('sale.returns')</a>
    
                {{-- <li @if(request()->segment(2) == '') class="active" @endif><a href="{{action('SellController@index')}}"><i class="fas fa-search me-2"></i> @lang('sale.sells')</a></li> --}}
                
            </div>
        </div>
    </div>
</nav>
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
                <a class="navbar-brand" href="{{action('SellController@index')}}"><i class="fa fas fa-dollar-sign bg-y"></i> {{__('sale.sells')}}</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li @if(request()->segment(2) == 'search') class="active" @endif><a href="{{action('SearchSellController@search')}}">@lang('lang_v1.search')</a></li>
                    <li @if(request()->segment(3) == 'confirmed') class="active" @endif><a href="{{action('SellController@index_confirm')}}">@lang('sale.index_confirm')</a></li>
                    <li @if(request()->segment(3) == 'ready') class="active" @endif><a href="{{action('SellController@index_ready')}}">@lang('sale.warehouse')</a></li>
                    <li @if(request()->segment(3) == 'review') class="active" @endif><a href="{{action('SellController@index_review')}}">@lang('sale.To_ship')</a></li>
                    <li @if(request()->segment(3) == 'recieved') class="active" @endif><a href="{{action('SellController@index_recieve')}}">@lang('sale.Out_for_delivery')</a></li>
                    <li @if(request()->segment(3) == 'delivered') class="active" @endif><a href="{{action('SellController@index_delivered')}}">@lang('sale.delivered')</a></li>
                    <li @if(request()->segment(3) == 'return') class="active" @endif><a href="{{action('SellController@return_recieve')}}">@lang('sale.returns')</a></li>

                    <li @if(request()->segment(2) == '') class="active" @endif><a href="{{action('SellController@index')}}">@lang('sale.sells')</a></li>

                  
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section>
--}}