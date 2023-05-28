<header class="header-area" id="header-area">
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container">
            <div class="site-logo">
                <a class="navbar-brand" href="{{route('welcome')}}"><img src="{{$__logo_url}}" class="img-fluid"  alt="logo" change-src-onscroll="{{$__logo_url}}" loading="lazy"/></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav" style="letter-spacing: 1px;">
                    <li class="nav-item dropdown">
                        <a  href="{{route('welcome')}}" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('cms::lang.home')</a>
                    </li>
                    <li class="nav-item"><a href="#" data-scroll-nav="1">@lang('cms::lang.features')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="2">@lang('cms::lang.how_it_work')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="3">@lang('cms::lang.screenshots')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="4">@lang('cms::lang.pricing')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="7">@lang('cms::lang.reviews')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="6">@lang('cms::lang.faqs')</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="8">@lang('cms::lang.contact')</a></li>
                    @if(Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="hero-nav__link">
                                <strong>
                                    @lang('cms::lang.dashboard')
                                </strong>
                            </a>
                        </li>
                    @endif
                    @if(Route::has('login') && ! Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('login') . '?lang=' . app()->getLocale()}}" class="hero-nav__link">
                                <strong>
                                    @lang('lang_v1.login')
                                </strong>
                            </a>
                        </li>
                    @endif
                    @if(! Auth::check())
                        <li class="nav-item">
                            <a href="{{ route('register') . '?lang=' . app()->getLocale()}}" target="_blank" class="hero-nav__link">@lang('cms::lang.register')</a>
                        </li>    
                    @endif
                    @if(app()->getLocale() == 'en')
                        <li class="nav-item">
                            <a class="hero-nav__link" href="{{route('welcome.lang','ar')}}">AR</a>
                        </li>    
                    @else
                        <li class="nav-item">
                            <a class="hero-nav__link" href="{{route('welcome.lang','en')}}">EN</a>
                        </li>    
                    @endif
                </ul>
            </div>
        </div>            
    </nav>
</header>