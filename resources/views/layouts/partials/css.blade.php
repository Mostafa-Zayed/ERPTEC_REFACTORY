@if( in_array(session()->get('user.language', config('app.locale')), config('system.langRtl')) )
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
@else
    <link rel="stylesheet" href="{{ asset('new_assets/css/bootstrap.min.css')}}">
@endif


@if(!empty(session('business.theme_color')) && session('business.theme_color') == 'orange')
    @php
        $theme = session('business.theme_color');
    @endphp
    <link rel="stylesheet" href="{{ asset('css/vendor_'.$theme.'.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('css/vendor.css?v='.$asset_v) }}">
@endif

@if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) )
	<link rel="stylesheet" href="{{ asset('css/rtl.css?v='.$asset_v) }}">
@endif

@yield('css')

<!-- app css -->
<link rel="stylesheet" href="{{ asset('css/app.css?v='.$asset_v) }}">

<link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel/assets/owl.carousel.min.css') }} ">
<link rel="stylesheet" href="{{ asset('front/vendor/owl.carousel/assets/owl.theme.default.min.css') }} ">

@if(isset($pos_layout) && $pos_layout)
	<style type="text/css">
		.content{
			padding-bottom: 0px !important;
		}
	</style>
@endif

@if(!empty($__system_settings['additional_css']))
    <style type="text/css">
        {!! $__system_settings['additional_css'] !!}
    </style>
@endif

<link rel="stylesheet" href="{{ asset('new_assets/css/style.css') }}">

@if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) )

    <link rel="stylesheet" href="{{ asset('new_assets/css/style-rtl.css') }} ">
@endif

<link rel="stylesheet" href="{{ asset('new_assets/css/custom.css') }} ">
<link rel="stylesheet" href="{{ asset('new_assets/css/responsive.css') }} ">
