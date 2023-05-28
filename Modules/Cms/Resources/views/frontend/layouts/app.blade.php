<!doctype html>
<html lang="{{app()->getLocale()}}" dir="{{in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr'}}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{config('app.name', 'ERP TEC')}} | @yield('title')</title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="author" content="ERP TEC - https://erptec.net/erp" />
        <meta name="keywords" content="ERP TEC" />
        
        <meta itemprop="name" content="ERP TEC">
        <meta itemprop="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta itemprop="image" content="{{asset('website/images/logo_test.png')}}">
        
        <meta property=”og:title” content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business" />
        <meta property=”og:url” content="https://erptec.net/erp" />
        <meta property=”og:type” content="website" />
        <meta property=”og:description” content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business" />
        <meta property=”og:image” content="{{asset('website/images/logo_test.png')}}" />
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@ERP TEC">
        <meta name="twitter:title" content="ERP TEC">
        <meta name="twitter:description" content="ERP TEC - is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="twitter:creator" content="@ERP TEC">
        <meta name="twitter:image:src" content="{{asset('website/images/logo_test.png')}}">
        
        <link rel="icon" href="{{asset('images/logo_test.png')}}">
        <!--<link rel="stylesheet" href="{{asset('public/css/website.css')}}">-->
        <!-- Font Icons -->
        <link rel="stylesheet" href="{{asset('modules/website/css/fontawesome.min.css')}}">
        <link rel="stylesheet" href="{{asset('modules/website/css/themify-icons.css')}}">
        <link rel="stylesheet" href="{{asset('modules/website/css/flaticon.css')}}">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="{{asset('modules/website/css/bootstrap.min.css')}}">
        <!-- Animation -->
        <link rel="stylesheet" href="{{asset('modules/website/css/animate.min.css')}}">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="{{asset('modules/website/css/owl.carousel.min.css')}}">
        <!-- Light Case -->
        <link rel="stylesheet" href="{{asset('modules/website/css/lightcase.min.css')}}" type="text/css">
        
        {{--
            <link rel="stylesheet" type="text/css" href="{{ asset('modules/cms/css/cms.css?v=' . $asset_v) }}">
        --}}
        <!-- Template style -->
        <link rel="stylesheet" href="{{asset('modules/website/css/style.css')}}">
        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        <!-- custom metas -->
        
        {{--
        @if(!empty($__site_details['meta_tags']))
            {!!$__site_details['meta_tags']!!}
        @endif
        --}}
        @yield('meta')
        
        
        <!-- font awesome 5 free -->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>-->
        <!-- Bootstrap 5 -->
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>-->

        <!-- Your Custom CSS file that will include your blocks CSS -->
        
        
        <script src="https://unpkg.com/tua-body-scroll-lock"></script>
        
        <!-- custom css code -->
        {{--
        @if(!empty($__site_details['custom_css']))
            {!!$__site_details['custom_css']!!}
        @endif
        --}}
        @yield('css')
    </head>
    <body>
        <!-- preloader -->
        <div id="preloader">
            <div id="preloader-circle">
                <span></span>
                <span></span>
            </div>
        </div>
        <!-- /preloader -->
        @yield('content')
        
        @includeIf('cms::frontend.layouts.footer')
        <!-- Start To Top Button -->
        <div id="back-to-top">
            <a class="top" id="top" href="#header-area"> <i class="ti-angle-up"></i> </a>
        </div>
        <!-- End To Top Button -->
        {{--
            <script src="{{asset('js/website.js')}}"></script>
        --}}
        <!-- Start JS FILES -->
        <!-- JQuery -->
        <script src="{{asset('modules/website/js/jquery.min.js')}}"></script>
        <script src="{{asset('modules/website/js/popper.min.js')}}"></script>
        <!-- Bootstrap -->
        <script src="{{asset('modules/website/js/bootstrap.min.js')}}"></script>
        <!-- Wow Animation -->
        <script src="{{asset('modules/website/js/wow.min.js')}}"></script>
        <!-- Owl Coursel -->
        <script src="{{asset('modules/website/js/owl.carousel.min.js')}}"></script>
        <!-- Images LightCase -->
        <script src="{{asset('modules/website/js/lightcase.min.js')}}"></script>
        <!-- scrollIt -->
        <script src="{{asset('modules/website/js/scrollIt.min.js')}}"></script>
        <!-- Main Script -->
        <script src="{{asset('modules/website/js/script.js')}}"></script>
        @yield('javascript')
    </body>
</html>        