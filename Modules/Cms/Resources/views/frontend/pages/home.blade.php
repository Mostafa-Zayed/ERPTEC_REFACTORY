@extends('cms::frontend.layouts.app')

@section('title', __('cms::lang.home'))

@section('content')
    @includeIf('cms::frontend.layouts.navbar')
    <!-- Start Home Area -->
    <section class="start_home demo1">
        <div class="banner_top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 start-home-content">
                        <h1>We Made our Software <br>Fully 100% Errorless!</h1>
                        <p style="letter-spacing: 1px;">@lang('cms::lang.slider_content')</p>
                    </div>
                    <div class="col-md-6 start-home-img">
                        <img class="img-fluid" src="{{asset('website/images/banner-2.png')}}" alt="banner"/>
                    </div>
                </div>
            </div>
        </div>
        <div class="shape-bottom">
            <img src="{{asset('website/images/shapes/shape-1.svg')}}" alt="shape" class="bottom-shape img-fluid">
        </div>
    </section>
    <!-- End Home Area -->

    <!-- Start How it works Section -->
    <section id="how-it-work" class="section-block" data-scroll-index="2">
            <div class="container">
                <div class="section-header">
                    <h2>@lang('cms::lang.how_it_work_headline')</h2>
                    <p style="letter-spacing: 1.5px;">@lang('cms::lang.how_it_work_description')</p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-box">
                            <img src="{{asset('website/images/how-work.png')}}" alt="Img" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <!-- Start Block 1 -->
                        <div class="description-block">
                            <div class="inner-box">
                                <div class="step_num"><img src="{{asset('website/images/step1.png')}}" /></div>
                                <h3>@lang('cms::lang.how_work_step1_title')</h3>
                                <p style="letter-spacing: 1px;">@lang('cms::lang.how_work_step1_content')<a href="{{ route('register') . '?lang=' . app()->getLocale()}}">@lang('cms::lang.new_account')</a></p>
                            </div>
                        </div>
                        <!-- End Block 1 -->

                        <!-- Start Block 2 -->
                        <div class="description-block">
                            <div class="inner-box">
                                <div class="step_num"><img src="{{asset('website/images/step2.png')}}" /></div>
                                <h3>@lang('cms::lang.how_work_step2_title')</h3>
                                <p style="letter-spacing: 1px;">@lang('cms::lang.how_work_step2_content')</p>
                            </div>
                        </div>
                        <!-- End Block 2 -->

                        <!-- Start Block 3 -->
                        <div class="description-block">
                            <div class="inner-box">
                                <div class="step_num"><img src="{{asset('website/images/step3.png')}}" /></div>
                                <h3>@lang('cms::lang.how_work_step3_title')</h3>
                                <p style="letter-spacing: 1px;">@lang('cms::lang.how_work_step3_content')</p>
                            </div>
                        </div>
                        <!-- End Block 3 -->
                    </div>

                </div>
            </div>
        </section>
    <!-- End How it works Section -->
    
    <!-- Start App Screenshots Section -->
    <!-- End App Screenshots Section -->
    
    <!-- Start Pricing Section -->
    <section id="pricing" class="section-block" data-scroll-index="4">
            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="section-header-style2">
                            <h2>No additional costs.<br>Pay for what you use.</h2>
                            <p>Choose the most suitable service for your needs with reasonable price.</p>
                        </div>
                        <ul class="nav pricing-btns-group">
                            <li><a class="active btn" data-toggle="tab" href="#monthly">Monthly</a></li>
                            <li><a class="btn" data-toggle="tab" href="#yearly">Yearly <span class="btn-badge">Free</span></a></li>
                        </ul>
                    </div>
                    <div class="col-md-7">
                        <div class="tab-content">
                            <!-- Start Tab content 1 -->
                            <div id="monthly" class="tab-pane fade in active show">
                                <div class="row">
                                    <!-- Start pricing table-->
                                    <div class="col-md-6">
                                        <div class="pricing-card">
                                            <header class="card-header">
                                                <h4>Free for 3 Months</h4>
                                                <span class="card-header-price">
                                                    <span class="simbole">$</span>
                                                    <span class="price-num">00</span>
                                                    <span class="price-date">/month</span>
                                                </span>
                                                <div class="shape-bottom">
                                                    <img src="{{asset('website/images/shapes/price-shape.svg')}}" alt="shape" class="bottom-shape img-fluid">
                                                </div>
                                            </header>
                                            <div class="card-body">
                                                <ul>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Users
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Products
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Invoices
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        The Shop
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Crm Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Essentials Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shipment Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Project Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shopify Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        WooCommerce Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Manufacturing Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Repair Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Product Catalogue Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        5 Trial Days
                                                    </li>
                                                </ul>
                                                <a href="https://erptec.net/erp/register?package=2" type="button" class="btn btn-sm btn-block">Get Started</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End pricing table-->

                                    <!-- Start pricing table-->
                                    <div class="col-md-6">
                                        <div class="pricing-card top-35">
                                            <header class="card-header">
                                                <h4>Free for 6 Months</h4>
                                                <span class="card-header-price">
                                                    <span class="simbole">$</span>
                                                    <span class="price-num">00</span>
                                                    <span class="price-date">/month</span>
                                                </span>
                                                <div class="shape-bottom">
                                                    <img src="{{asset('website/images/shapes/price-shape.svg')}}" alt="shape" class="bottom-shape img-fluid">
                                                </div>
                                            </header>
                                            <div class="card-body">
                                                 <ul>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Users
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Products
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Invoices
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        The Shop
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Crm Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Essentials Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shipment Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Project Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shopify Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        WooCommerce Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Manufacturing Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Repair Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Product Catalogue Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        5 Trial Days
                                                    </li>
                                                </ul>
                                                <a type="button" class="btn btn-sm btn-block" href="https://erptec.net/erp/register?package=4">Get Started</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End pricing table-->
                                </div>
                            </div>
                            <!-- End Tab content 1 -->

                            <!-- Start Tab content 2 -->
                            <div id="yearly" class="tab-pane fade">
                                <div class="row">
                                    <!-- Start pricing table-->
                                    <div class="col-md-6">
                                        <div class="pricing-card">
                                            <header class="card-header">
                                                <h4>Free for 1 Year</h4>
                                                <span class="card-header-price">
                                                    <span class="simbole">$</span>
                                                    <span class="price-num">00</span>
                                                    <span class="price-date">/month</span>
                                                </span>
                                                <div class="shape-bottom">
                                                    <img src="{{asset('website/images/shapes/price-shape.svg')}}" alt="shape" class="bottom-shape img-fluid">
                                                </div>
                                            </header>
                                            <div class="card-body">
                                                 <ul>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Users
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Products
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Invoices
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        The Shop
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Crm Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Essentials Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shipment Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Project Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shopify Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        WooCommerce Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Manufacturing Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Repair Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Product Catalogue Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        5 Trial Days
                                                    </li>
                                                </ul>
                                                <a href="https://erptec.net/erp/register?package=5" type="button" class="btn btn-sm btn-block">Get Started</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End pricing table-->

                                    <!-- Start pricing table-->
                                    <div class="col-md-6">
                                        <div class="pricing-card top-35">
                                            <header class="card-header">
                                                <h4>Free for 2 Years</h4>
                                                <span class="card-header-price">
                                                    <span class="simbole">$</span>
                                                    <span class="price-num">00</span>
                                                    <span class="price-date">/month</span>
                                                </span>
                                                <div class="shape-bottom">
                                                    <img src="{{asset('website/images/shapes/price-shape.svg')}}" alt="shape" class="bottom-shape img-fluid">
                                                </div>
                                            </header>
                                            <div class="card-body">
                                                 <ul>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Users
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Products
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        300 Invoices
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        The Shop
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Crm Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        1 Business Locations
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Essentials Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shipment Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Project Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Shopify Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        WooCommerce Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Manufacturing Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Repair Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        Product Catalogue Module
                                                    </li>
                                                    <li>
                                                        <span class="fas fa-check"></span>
                                                        5 Trial Days
                                                    </li>
                                                </ul>
                                                <a href="https://erptec.net/erp/register?package=6" type="button" class="btn btn-sm btn-block">Get Started</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End pricing table-->
                                </div>
                            </div>
                            <!-- End Tab content 2 -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- End Pricing Section -->

    <!-- Start Faqs Section -->
    <section id="faqs" class="section-block" data-scroll-index="6">
            <div class="container">
                <div class="section-header">
                    <h2>Frequently Asked Questions</h2>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis accumsan <br>
                        nisi Ut ut felis congue nisl hendrerit commodo.
                    </p>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="img-box">
                            <img src="{{asset('website/images/faq2.png')}}" class="img-fluid" alt="Img" />
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="accordion" id="accordionExample">
                            <!-- Start Faq item -->
                            <div class="card">
                                <div class="card-header" id="headingOne">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            What is the best features and services we deiver?
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore omnis quaerat nostrum, pariatur ipsam sunt accusamus enim necessitatibus est fugiat, assumenda dolorem, deleniti corrupti cupiditate ipsum, dolorum voluptatum esse error?
                                    </div>
                                </div>
                            </div>
                            <!-- End Faq item -->

                            <!-- Start Faq item -->
                            <div class="card">
                                <div class="card-header" id="headingTwo">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            Why this app important to me?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore omnis quaerat nostrum, pariatur ipsam sunt accusamus enim necessitatibus est fugiat, assumenda dolorem, deleniti corrupti cupiditate ipsum, dolorum voluptatum esse error?
                                    </div>
                                </div>
                            </div>
                            <!-- End Faq item -->

                            <!-- Start Faq item -->
                            <div class="card">
                                <div class="card-header" id="headingThree">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                            how may I take part in and purchase this Software?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore omnis quaerat nostrum, pariatur ipsam sunt accusamus enim necessitatibus est fugiat, assumenda dolorem, deleniti corrupti cupiditate ipsum, dolorum voluptatum esse error?
                                    </div>
                                </div>
                            </div>
                            <!-- End Faq item -->

                            <!-- Start Faq item -->
                            <div class="card">
                                <div class="card-header" id="headingFour">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            What are the objectives of this Software?
                                        </button>
                                    </h2>
                                </div>
                                <div id="collapseFour" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                                    <div class="card-body">
                                        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore omnis quaerat nostrum, pariatur ipsam sunt accusamus enim necessitatibus est fugiat, assumenda dolorem, deleniti corrupti cupiditate ipsum, dolorum voluptatum esse error?
                                    </div>
                                </div>
                            </div>
                            <!-- End Faq item -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <!-- End Faqs Section -->
    
    <!-- Start Contact Section -->
    <section id="contact" class="section-block" data-scroll-index="8">
            <div class="bubbles-animate">
                <div class="bubble b_one"></div>
                <div class="bubble b_two"></div>
                <div class="bubble b_three"></div>
                <div class="bubble b_four"></div>
                <div class="bubble b_five"></div>
                <div class="bubble b_six"></div>
            </div>
            <div class="container">
                <div class="row">
                    <!-- Start Contact Information -->
                    <div class="col-md-5">
                        <div class="section-header-style2">
                            <h2>@lang('cms::lang.contact_us')</h2>
                            <p style="letter-spacing: 1px;">
                                @lang('cms::lang.contact_title')
                            </p>
                        </div>
                        <div class="contact-details">
                            <!-- Start Contact Block -->
                            <div class="contact-block">
                                <h4>Office Location</h4>
                                <div class="contact-block-side">
                                    <i class="flaticon-route"></i>
                                    <p>
                                        <span>12 Street Name, </span>
                                        <span>Calefornia, United States.</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Contact Block -->

                            <!-- Start Contact Block -->
                            <div class="contact-block">
                                <h4>Office Hours</h4>
                                <div class="contact-block-side">
                                    <i class="flaticon-stopwatch-4"></i>
                                    <p>
                                        <span>Saturday - Thursday </span>
                                        <span>9:00 AM - 5:00 PM</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Contact Block -->

                            <!-- Start Contact Block -->
                            <div class="contact-block">
                                <h4>Phone</h4>
                                <div class="contact-block-side">
                                    <i class="flaticon-smartphone-7"></i>
                                    <p>
                                        <span>+201014938029</span>
                                        <span>+201014938029</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Contact Block -->

                            <!-- Start Contact Block -->
                            <div class="contact-block">
                                <h4>Email</h4>
                                <div class="contact-block-side">
                                    <i class="flaticon-paper-plane-1"></i>
                                    <p>
                                        <span>info@erptec.net</span>
                                        <span>support@erptec.net</span>
                                    </p>
                                </div>
                            </div>
                            <!-- End Contact Block -->
                        </div>
                    </div>
                    <!-- End Contact Information -->

                    <!-- Start Contact form Area -->
                    <div class="col-md-7">
                        <div class="contact-shape">
                            <img src="{{asset('website/images/shapes/contact-form.png')}}" class="img-fluid" alt="Img"/>
                        </div>
                        <div class="contact-form-block">
                            <div class="section-header-style2">
                                <h2>Let's talk about your idea</h2>
                                <p>
                                    Check these testimonials from our satisfied customers!
                                </p>
                            </div>
                            <form class="contact-form" id="form_send_message">
                                @csrf
                                <input type="text" name="name" class="form-control" placeholder="You Name" id="customer_name" />
                                <input type="email" name="email" class="form-control" placeholder="You Email" id="customer_email" />
                                <input type="tel" name="phone" class="form-control" placeholder="You Phone" id="customer_phone" />
                                <textarea  name="message" class="form-control" placeholder="Your Message" id="customer_message"></textarea>
                                <button class="btn theme-btn">Send Message</button>
                            </form>
                        </div>

                    </div>
                    <!-- End Contact form Area -->
                </div>
            </div>
        </section>
    <!-- End Contact Section -->
@endsection

@section('javascript')
<script>
    $(document).ready(function(){
        $('form#form_send_message').submit(function(evt){
            evt.preventDefault();
            let token = $('input[name="_token"]').attr('value');
            let customerName = $('input#customer_name').val();
            let customerEmail = $('input#customer_email').val();
            let customerPhone = $('input#customer_phone').val();
            let customerMessage = $('#customer_message').val();
            
            $.ajax({
                url: "{{route('cms.submit.contact.form')}}",
                type: 'POST',
                headers: {
                    'X-CSRF-Token': token
                },
                data: {
                    name: customerName,
                    email: customerEmail,
                    mobile: customerPhone,
                    message: customerMessage
                },
                success: function(result){
                    console.log(result);
                }
            });
            //action="{{}}" method="post" 
        });
    });
</script>
@endsection