<template>
<header class="header-area" id="header-area">
            <nav class="navbar navbar-expand-md fixed-top">
                <div class="container">
                    <div class="site-logo"><a class="navbar-brand" href="index.html"><img v-bind:src="getLogoImage" class="img-fluid" alt="Img" /></a></div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Home</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="index.html">Home Demo 01</a>
                                    <a class="dropdown-item" href="index-2.html">Home Demo 02</a>
                                    <a class="dropdown-item" href="index-3.html">Home Demo 03</a>
                                    <a class="dropdown-item" href="index-4.html">Home Demo 04</a>
                                    <a class="dropdown-item" href="index-5.html">Home Demo 05</a>
                                    <a class="dropdown-item" href="index-6.html">Home Demo 06</a>
                                    <a class="dropdown-item" href="index-7.html">Home Demo 07</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Pages</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                    <a class="dropdown-item" href="about-us.html">About Us</a>
                                    <a class="dropdown-item" href="contact-us.html">Contact Us</a>
                                    <a class="dropdown-item" href="faqs.html">Faqs</a>
                                    <a class="dropdown-item" href="reviews.html">Reviews</a>
                                    <a class="dropdown-item" href="signin.html">Login</a>
                                    <a class="dropdown-item" href="signup.html">Signup</a>
                                    <a class="dropdown-item" href="recover-account.html">Forget Password</a>
                                    <a class="dropdown-item" href="coming-soon.html">Coming Soon</a>
                                    <a class="dropdown-item" href="error-404.html">Page 404</a>
                                </div>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="dropdown-toggle" href="#" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Blog</a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                    <a class="dropdown-item" href="blog-1.html">Blog Demo 1</a>
                                    <a class="dropdown-item" href="blog-2.html">Blog Demo 2</a>
                                    <a class="dropdown-item" href="single-post.html">Single Post</a>
                                </div>
                            </li>
                            <li class="nav-item"><a href="#" data-scroll-nav="1">Features</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="2">How it work</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="3">Screenshots</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="4">Pricing</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="7">Reviews</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="6">Faqs</a></li>
                            <li class="nav-item"><a href="#" data-scroll-nav="8">Contact</a></li>
                        </ul>

                    </div>
                </div>
            </nav>
        </header>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        props:{
            logoImage: 'https://www.erptec.net/erp/public/modules/website/ltr/images/logo-2.png'
        },
        computed: {
            getLogoImage(){
                return 'https://www.erptec.net/erp/public/modules/website/ltr/images/logo-2.png';
            }
        }
    }
</script>