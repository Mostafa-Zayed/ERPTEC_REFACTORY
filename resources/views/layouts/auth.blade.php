<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{asset('website/images/logo_test.png')}}">
    <title>@yield('title') - {{ config('app.name', 'ERP TEC') }}</title> 
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }} ">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    
    @include('layouts.partials.css')
    <link rel="stylesheet" href="{{ asset('css/style-v1.css') }}">
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
            body {
                /*background-color: #243949;*/
                background-color: #6622D5;
            }
            h1 {
                color: #fff;
            }
    </style>
</head>
<script src="https://kit.fontawesome.com/294faa75f4.js" crossorigin="anonymous"></script>
<body class="hold-transition">
    @if (session('status'))
        <input type="hidden" id="status_span" data-status="{{ session('status.success') }}" data-msg="{{ session('status.msg') }}">
    @endif

    @if(!isset($no_header))
        @include('layouts.partials.header-auth')
    @endif

    @yield('content')
    
    @include('layouts.partials.javascripts')
    <!-- Scripts -->
    <script src="{{ asset('js/login.js?v=' . $asset_v) }}"></script>
    @yield('javascript')

    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>