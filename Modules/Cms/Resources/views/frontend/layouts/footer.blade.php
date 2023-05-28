<footer>
    <div class="shape-top"></div>
    <div class="container">
        <!-- End Footer Top  Area -->
        <div class="top-footer">
            <div class="row">
                <!-- Start Column 1 -->
                <div class="col-md-4">
                    <div class="footer-logo">
                        <img src="{{asset('website/images/logo.png')}}" class="img-fluid" alt="logo" />
                    </div>
                    <p style="letter-spacing: 1px;">@lang('cms::lang.slider_content')</p>
                    <div class="footer-social-links">
                        <a href="#"><i class="ti-facebook"></i></a>
                        <a href="#"><i class="ti-twitter-alt"></i></a>
                        <a href="#"><i class="ti-instagram"></i></a>
                        <a href="#"><i class="ti-pinterest"></i></a>
                    </div>
                </div>
                <!-- End Column 1 -->

                <!-- Start Column 2 -->
                <div class="col-md-2">
                    <h4 class="footer-title">@lang('cms::lang.useful_links')</h4>
                    <ul class="footer-links">
                        <li><a href="{{route('welcome') . '/' . app()->getLocale()}}">@lang('cms::lang.home')</a></li>
                        <li><a href="#contact">@lang('cms::lang.contact')</a></li>
                        <li><a href="#reviews">@lang('cms::lang.reviews')</a></li>
                        <li><a href="#faqs">@lang('cms::lang.faqs')</a></li>
                    </ul>
                </div>
                <!-- End Column 2 -->

                <!-- Start Column 3 -->
                <div class="col-md-2">
                    <h4 class="footer-title">User Account</h4>
                    <ul class="footer-links">
                        <li><a href="{{ route('login') . '?lang=' . app()->getLocale()}}" target="_blank">@lang('lang_v1.login')</a></li>
                        <li><a href="{{ route('register') . '?lang=' . app()->getLocale()}}" target="_blank">@lang('cms::lang.register')</a></li>
                        <li><a href="{{url('password/reset')}}" target="_blank">Reset Password</a></li>
                    </ul>
                </div>
                <!-- End Column 3 -->

                <!-- Start Column 4 -->
                <div class="col-md-4">
                    <h4 class="footer-title">Newsletter</h4>
                    <p>Subscribe our newsletter to get our update. We don't send span email to you.</p>
                    <form class="newsletter-form">
                        <input type="email" placeholder="Enter Your Email" />
                        <button class="btn theme-btn">Subscribe</button>
                    </form>
                </div>
                <!-- End Column 4 -->
            </div>
        </div>
        <!-- End Footer Top  Area -->

        <!-- Start Copyrights Area -->
        <div class="copyrights">
            <p>Copyrights © 2023. Designed by  <i class="flaticon-like-2"></i> <a href="{{route('welcome') . '/' . app()->getLocale()}}"> ERP TEC </a>.</p>
        </div>
        <!-- End Copyrights Area -->
    </div>
</footer>
<!-- End Footer Area -->

{{--
<!------------------------------>
<!--Footer---------------->
<!------------------------------>
<div class="block-44">
    <hr class="block-44__divider">
    <div class="container">
        <div class="row flex-column flex-md-row px-2 justify-content-center">
            @if(isset($__site_details['follow_us']) && !empty($__site_details['follow_us']))
                <div class="flex-grow-1 col">
                    <ul class="block-44__extra-links d-flex list-unstyled p-0">
                        @foreach($__site_details['follow_us'] as $key => $follow_us)
                            @if($key == 'facebook' && !empty($follow_us))
                                <li class="mx-2">
                                    <a href="{{$follow_us??'#'}}" target="_blank" title="Facebook" class="block-44__link m-0">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                </li>
                            @endif
                            @if($key == 'instagram' && !empty($follow_us))
                                <li class="mx-2">
                                    <a href="{{$follow_us??'#'}}" target="_blank" title="Instagram" class="block-44__link m-0">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                </li>
                            @endif
                            @if($key == 'twitter' && !empty($follow_us))
                                <li class="mx-2">
                                    <a href="{{$follow_us??'#'}}" target="_blank" title="Twitter" class="block-44__link m-0">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                </li>
                            @endif
                            @if($key == 'linkedin' && !empty($follow_us))
                                <li class="mx-2">
                                    <a href="{{$follow_us??'#'}}" target="_blank" title="Linkedin" class="block-44__link m-0">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </li>
                            @endif
                            @if($key == 'youtube' && !empty($follow_us))
                                <li class="mx-2">
                                    <a href="{{$follow_us??'#'}}" target="_blank" title="YouTube" class="block-44__link m-0">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endif
            <p class="block-41__copyrights col col-md-8 text-xxl-end text-xl-end text-lg-end text-md-end text-sm-center">
                &copy; &nbsp;{{ date('Y')}} &nbsp;{{config('app.name', 'ERP TEC')}}. &nbsp;All Rights Reserved.
            </p>
        </div>
    </div>
  </div>
  --}}
