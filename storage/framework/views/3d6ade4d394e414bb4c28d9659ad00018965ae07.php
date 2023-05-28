<footer>
    <div class="shape-top"></div>
    <div class="container">
        <!-- End Footer Top  Area -->
        <div class="top-footer">
            <div class="row">
                <!-- Start Column 1 -->
                <div class="col-md-4">
                    <div class="footer-logo">
                        <img src="<?php echo e(asset('website/images/logo.png'), false); ?>" class="img-fluid" alt="logo" />
                    </div>
                    <p style="letter-spacing: 1px;"><?php echo app('translator')->getFromJson('cms::lang.slider_content'); ?></p>
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
                    <h4 class="footer-title"><?php echo app('translator')->getFromJson('cms::lang.useful_links'); ?></h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(route('welcome') . '/' . app()->getLocale(), false); ?>"><?php echo app('translator')->getFromJson('cms::lang.home'); ?></a></li>
                        <li><a href="#contact"><?php echo app('translator')->getFromJson('cms::lang.contact'); ?></a></li>
                        <li><a href="#reviews"><?php echo app('translator')->getFromJson('cms::lang.reviews'); ?></a></li>
                        <li><a href="#faqs"><?php echo app('translator')->getFromJson('cms::lang.faqs'); ?></a></li>
                    </ul>
                </div>
                <!-- End Column 2 -->

                <!-- Start Column 3 -->
                <div class="col-md-2">
                    <h4 class="footer-title">User Account</h4>
                    <ul class="footer-links">
                        <li><a href="<?php echo e(route('login') . '?lang=' . app()->getLocale(), false); ?>" target="_blank"><?php echo app('translator')->getFromJson('lang_v1.login'); ?></a></li>
                        <li><a href="<?php echo e(route('register') . '?lang=' . app()->getLocale(), false); ?>" target="_blank"><?php echo app('translator')->getFromJson('cms::lang.register'); ?></a></li>
                        <li><a href="<?php echo e(url('password/reset'), false); ?>" target="_blank">Reset Password</a></li>
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
            <p>Copyrights © 2023. Designed by  <i class="flaticon-like-2"></i> <a href="<?php echo e(route('welcome') . '/' . app()->getLocale(), false); ?>"> ERP TEC </a>.</p>
        </div>
        <!-- End Copyrights Area -->
    </div>
</footer>
<!-- End Footer Area -->


<?php /**PATH F:\ERPTEC_REFACTORY_5.8\Modules\Cms\Providers/../Resources/views/frontend/layouts/footer.blade.php ENDPATH**/ ?>