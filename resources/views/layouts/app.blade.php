@inject('request', 'Illuminate\Http\Request')

@php $pos_layout = is_pos_layout();@endphp
@php $business = get_business(); @endphp

<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr'}}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <meta name="keywords" content="ERP TEC"/>
        <meta name="description" content="">
		<meta name="author" content="">
		<meta property=”og:title” content=”” />
        <meta property=”og:url” content=”https://erptec.net/erp” />
        <meta property=”og:type” content=”website” />
        <meta property=”og:description” content=”” />
        <meta property=”og:image” content=”” />
        
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="icon" href="{{asset('website/images/logo_test.png')}}" type="image/gif" sizes="16x16">

        <title>@yield('title') - {{ Session::get('business.name') }}</title>
        
		
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;700;900&display=swap" rel="stylesheet">
        
        @include('layouts.partials.css')
        
        <link rel="stylesheet" href="{{ asset('css/style-v1.css') }}">
        
        @yield('css')
    </head>

    <body class="@if($pos_layout) hold-transition lockscreen @else hold-transition skin-{{get_business_theme_color()}} sidebar-mini @endif">
        <div class="wrapper thetop">
            <script type="text/javascript">
                if(localStorage.getItem("upos_sidebar_collapse") == 'true'){
                    var body = document.getElementsByTagName("body")[0];
                    body.className += " sidebar-collapse";
                }
            </script>
            @if(!$pos_layout)
                @include('layouts.partials.header')
                @include('layouts.partials.sidebar')
            @else
                @include('layouts.partials.header-pos')
            @endif

            <!-- Content Wrapper. Contains page content -->
            <div class="@if(!$pos_layout) content-wrapper @endif">
                <!-- empty div for vuejs -->
                <div id="app">
                    @yield('vue')
                </div>
                <!-- Add currency related field-->
                <input type="hidden" id="__code" value="{{session('currency')['code']}}">
                <input type="hidden" id="__symbol" value="{{session('currency')['symbol']}}">
                <input type="hidden" id="__thousand" value="{{session('currency')['thousand_separator']}}">
                <input type="hidden" id="__decimal" value="{{session('currency')['decimal_separator']}}">
                <input type="hidden" id="__symbol_placement" value="{{session('business.currency_symbol_placement')}}">
                <input type="hidden" id="__precision" value="{{config('constants.currency_precision', 2)}}">
                <input type="hidden" id="__quantity_precision" value="{{config('constants.quantity_precision', 2)}}">
                <!-- End of currency related field-->

                @if (session('status'))
                    <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
                @endif
                @yield('content')

                <div class='scrolltop no-print'>
                    <div class='scroll icon'><i class="fas fa-angle-up"></i></div>
                </div>

                @if(config('constants.iraqi_selling_price_adjustment'))
                    <input type="hidden" id="iraqi_selling_price_adjustment">
                @endif

                <!-- This will be printed -->
                <section class="invoice print_section" id="receipt_section">
                </section>
                
            </div>
            @include('home.todays_profit_modal')
            <!-- /.content-wrapper -->

            @if(!$pos_layout)
                @include('layouts.partials.footer')
            @else
                @include('layouts.partials.footer_pos')
            @endif

            <audio id="success-audio">
              <source src="{{ asset('audio/success.ogg?v=' . $asset_v) }}" type="audio/ogg">
              <source src="{{ asset('audio/success.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
            <audio id="error-audio">
              <source src="{{ asset('audio/error.ogg?v=' . $asset_v) }}" type="audio/ogg">
              <source src="{{ asset('audio/error.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
            <audio id="warning-audio">
              <source src="{{ asset('audio/warning.ogg?v=' . $asset_v) }}" type="audio/ogg">
              <source src="{{ asset('audio/warning.mp3?v=' . $asset_v) }}" type="audio/mpeg">
            </audio>
        </div>

        @if(!empty($__additional_html))
            {!! $__additional_html !!}
        @endif

        @include('layouts.partials.javascripts')

        <div class="modal fade view_modal" tabindex="-1" role="dialog" 
        aria-labelledby="gridSystemModalLabel"></div>

        @if(!empty($__additional_views) && is_array($__additional_views))
            @foreach($__additional_views as $additional_view)
                @includeIf($additional_view)
            @endforeach
        @endif
        
        <script>
            $(document).ready(function(){
                
                // Change Language App
                $(".selectors").on('change',function () {
                    window.location = $(this).val();
                });
            });
        </script>
    </body>

</html>