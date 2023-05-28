<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>ERP TEC</title>
        <meta name="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="author" content="ERP TEC - https://erptec.net/erp" />
        
        <meta itemprop="name" content="ERP TEC">
        <meta itemprop="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta itemprop="image" content="{{asset('public/website/images/logo_test.png')}}">
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@ERP TEC">
        <meta name="twitter:title" content="ERP TEC">
        <meta name="twitter:description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="twitter:creator" content="@ERP TEC">
        <meta name="twitter:image:src" content="{{asset('public/website/images/logo_test.png')}}">
        
        <link rel="icon" href="{{asset('public/website/images/logo_test.png')}}">
        <!-- Font Icons -->
        <link rel="stylesheet" href="{{asset('public/css/website.css')}}">
        <link rel="stylesheet" href="{{asset('public/new_assets/intlTelInput/css/intlTelInput.min.css')}}"/>
        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="login-page">
            <div class="col-md-4 login-side-des">
                <div class="container-fluid">
                    <div class="login-side-block">
                        <a href="index.html"><img src="{{asset('public/website/images/logo_white.png')}}" alt="Logo"/> <span style="color:white;font-size: 16px;">ERP TEC</span></a>
                        <div class="login-reviews">
                            <div class="review-details-content">
                                <div class="owl-carousel review_details" id="review_details-2">
                                    <div class="item">
                                        <p>"Thank you for guiding us through the construction process, understanding, and always ready to accommodate our needs."</p>
                                        <h5>Sarah Carlos</h5>
                                        <h6>Creative Director</h6>
                                    </div>
                                    <div class="item">
                                        <p>"Thank you for guiding us through the construction process, understanding, and always ready to accommodate our needs."</p>
                                        <h5>Sarah Carlos</h5>
                                        <h6>Creative Director</h6>
                                    </div>
                                    <div class="item">
                                        <p>"Thank you for guiding us through the construction process, understanding, and always ready to accommodate our needs."</p>
                                        <h5>Sarah Carlos</h5>
                                        <h6>Creative Director</h6>
                                    </div>
                                    <div class="item">
                                        <p>"Thank you for guiding us through the construction process, understanding, and always ready to accommodate our needs."</p>
                                        <h5>Sarah Carlos</h5>
                                        <h6>Creative Director</h6>
                                    </div>
                                    <div class="item">
                                        <p>"Thank you for guiding us through the construction process, understanding, and always ready to accommodate our needs."</p>
                                        <h5>Sarah Carlos</h5>
                                        <h6>Creative Director</h6>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="review-photo-list">-->
                            <!--    <div class="owl-carousel review_photo" id="review_photo-2">-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--        <div class="item">-->
                            <!--            <div class="review_photo_block">-->
                            <!--                <img src="images/blog/author-1.jpg" alt="IMG">-->
                            <!--            </div>-->
                            <!--        </div>-->
                            <!--    </div>-->
                            <!--</div>-->
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="container-fluid">
                    <!--<a href="index.html"><img src="{{asset('public/website/images/logo_test.png')}}" alt="Logo"/> <span style="color:white;font-size: 16px;">ERP TEC</span></a>-->
                    <div class="login-form">
                        <div class="login-form-head">
                            <h2>Welcome to ERP TEC</h2>
                            <p>Fill out the form to get started..</p>
                        </div>
                        {!! Form::open(['url' => route('business.postRegister'), 'method' => 'post', 
                            'id' => 'business_register_form','files' => true ]) !!}
                            <div class="form-group">
                                <label class="form-label" for="business_name">Business Name</label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <span class="ti-email"></span>
                                    </div>
                                    <input type="text" class="form-control" name="business_name" id="business_name" placeholder="Business Name" aria-label="Business Name" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signinEmail">Email address</label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <span class="ti-email"></span>
                                    </div>
                                    <input type="email" class="form-control" name="email" id="signinEmail" placeholder="Email address" aria-label="Email address" required="">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="signinPassword">
                                    Password
                                </label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <span class="ti-lock"></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="signinPassword" placeholder="********" aria-label="Password" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="signinPassword2"> Confirm Password</label>
                                <div class="input-group">
                                    <div class="input-icon">
                                        <span class="ti-lock"></span>
                                    </div>
                                    <input type="password" class="form-control" name="password" id="signinPassword2" placeholder="********" aria-label="Password" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                {!! Form::label('currency_id', __('business.currency')) !!}

                                {!! Form::select('currency_id', $currencies, '', ['class' => 'form-control select2_register currency','placeholder' => __('business.currency_placeholder'), 'required']); !!}
        
                            </div>
                            <div class="form-group">
                                <p class="checkboxes">
                                    <input id="check-er" type="checkbox" name="check">
                                    <label for="check-er">I agree to the <a href="#">terms and conditions</a></label>
                                </p>
                            </div>
                            <div class="form-group">
                                <button class="btn theme-btn btn-block" type="submit">Get Started</button>
                            </div>
                            <div class="form-group login-desc">
                                <p> Already have an account? <a href="signin.html">Sign In</a></p>
                            </div>
                        {!! Form::close() !!}
                    </div>

                </div>
            </div>

        </div>
        <!-- Start JS FILES -->
        <!-- JQuery -->
        <script src="{{asset('public/js/website.js')}}"></script>
        @yield('js')
    </body>
</html>