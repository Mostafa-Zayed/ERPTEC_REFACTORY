{{--<ul class="navbar-nav">
                    <li class="nav-item"><a href="/" data-scroll-nav="1">Home</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="2">Features</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="3">Screenshots</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="4">Pricing</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="8">About us</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="7">Reviews</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="6">Faqs</a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="8">Contact</a></li>
                    {{--
                    <li class="nav-item dropdown">
                        <a class="dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item" href="about-us.html">About Us</a>
                                    <a class="dropdown-item" href="contact-us.html">Contact Us</a>
                                    <a class="dropdown-item" href="faqs.html">Faqs</a>
                                    <a class="dropdown-item" href="reviews.html">Reviews</a>
                                    <a class="dropdown-item" href="login.html">Login</a>
                                    <a class="dropdown-item" href="signup.html">Signup</a>
                                    <a class="dropdown-item" href="forget-password.html">Forget Password</a>
                                    <a class="dropdown-item" href="reset-password.html">Reset Password</a>
                                    <a class="dropdown-item" href="coming-soon.html">Coming Soon</a>
                                    <a class="dropdown-item" href="page-404.html">Page 404</a>
                                </div>
                    </li>
                    --}}
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
                            <a href="{{ route('login') }}" class="hero-nav__link">
                                <strong>
                                    @lang('lang_v1.login')
                                </strong>
                            </a>
                        </li>
                    @endif
                    
                    @if(! Auth::check())
                        <a href="{{ route('register') }}" target="_blank" class="btn btn-primary">Try For Free</a>
                    @endif                    
                </ul> --}}