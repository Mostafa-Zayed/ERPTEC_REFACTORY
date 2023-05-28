<!doctype html>
<html lang="<?php echo e(app()->getLocale(), false); ?>" dir="<?php echo e(in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ? 'rtl' : 'ltr', false); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title><?php echo e(config('app.name', 'ERP TEC'), false); ?> | <?php echo $__env->yieldContent('title'); ?></title>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">
        <meta name="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="author" content="ERP TEC - https://erptec.net/erp" />
        <meta name="keywords" content="ERP TEC" />
        
        <meta itemprop="name" content="ERP TEC">
        <meta itemprop="description" content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta itemprop="image" content="<?php echo e(asset('website/images/logo_test.png'), false); ?>">
        
        <meta property=”og:title” content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business" />
        <meta property=”og:url” content="https://erptec.net/erp" />
        <meta property=”og:type” content="website" />
        <meta property=”og:description” content="ERP TEC is E-Commerce ERP System, Specialized solutions to manage your business" />
        <meta property=”og:image” content="<?php echo e(asset('website/images/logo_test.png'), false); ?>" />
        
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:site" content="@ERP  TEC">
        <meta name="twitter:title" content="ERP TEC">
        <meta name="twitter:description" content="ERP TEC - is E-Commerce ERP System, Specialized solutions to manage your business">
        <meta name="twitter:creator" content="@ERP  TEC">
        <meta name="twitter:image:src" content="<?php echo e(asset('website/images/logo_test.png'), false); ?>">
        
        <link rel="icon" href="<?php echo e(asset('images/logo_test.png'), false); ?>">
        <!--<link rel="stylesheet" href="<?php echo e(asset('public/css/website.css'), false); ?>">-->
        <!-- Font Icons -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/fontawesome.min.css'), false); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/themify-icons.css'), false); ?>">
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/flaticon.css'), false); ?>">
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/bootstrap.min.css'), false); ?>">
        <!-- Animation -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/animate.min.css'), false); ?>">
        <!-- Owl Carousel -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/owl.carousel.min.css'), false); ?>">
        <!-- Light Case -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/lightcase.min.css'), false); ?>" type="text/css">
        
        
        <!-- Template style -->
        <link rel="stylesheet" href="<?php echo e(asset('modules/website/css/style.css'), false); ?>">
        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->
        <!-- custom metas -->
        
        
        <?php echo $__env->yieldContent('meta'); ?>
        
        
        <!-- font awesome 5 free -->
        <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css"/>-->
        <!-- Bootstrap 5 -->
        <!--<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"/>-->

        <!-- Your Custom CSS file that will include your blocks CSS -->
        
        
        <script src="https://unpkg.com/tua-body-scroll-lock"></script>
        
        <!-- custom css code -->
        
        <?php echo $__env->yieldContent('css'); ?>
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
        <?php echo $__env->yieldContent('content'); ?>
        
        <?php if ($__env->exists('cms::frontend.layouts.footer')) echo $__env->make('cms::frontend.layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- Start To Top Button -->
        <div id="back-to-top">
            <a class="top" id="top" href="#header-area"> <i class="ti-angle-up"></i> </a>
        </div>
        <!-- End To Top Button -->
        
        <!-- Start JS FILES -->
        <!-- JQuery -->
        <script src="<?php echo e(asset('modules/website/js/jquery.min.js'), false); ?>"></script>
        <script src="<?php echo e(asset('modules/website/js/popper.min.js'), false); ?>"></script>
        <!-- Bootstrap -->
        <script src="<?php echo e(asset('modules/website/js/bootstrap.min.js'), false); ?>"></script>
        <!-- Wow Animation -->
        <script src="<?php echo e(asset('modules/website/js/wow.min.js'), false); ?>"></script>
        <!-- Owl Coursel -->
        <script src="<?php echo e(asset('modules/website/js/owl.carousel.min.js'), false); ?>"></script>
        <!-- Images LightCase -->
        <script src="<?php echo e(asset('modules/website/js/lightcase.min.js'), false); ?>"></script>
        <!-- scrollIt -->
        <script src="<?php echo e(asset('modules/website/js/scrollIt.min.js'), false); ?>"></script>
        <!-- Main Script -->
        <script src="<?php echo e(asset('modules/website/js/script.js'), false); ?>"></script>
        <?php echo $__env->yieldContent('javascript'); ?>
    </body>
</html>        <?php /**PATH F:\ERPTEC_REFACTORY_5.8\Modules\Cms\Providers/../Resources/views/frontend/layouts/app.blade.php ENDPATH**/ ?>