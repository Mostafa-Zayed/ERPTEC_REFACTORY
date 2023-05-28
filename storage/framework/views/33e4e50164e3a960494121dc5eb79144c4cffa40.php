<header class="header-area" id="header-area">
    <nav class="navbar navbar-expand-md fixed-top">
        <div class="container">
            <div class="site-logo">
                <a class="navbar-brand" href="<?php echo e(route('welcome'), false); ?>"><img src="<?php echo e($__logo_url, false); ?>" class="img-fluid"  alt="logo" change-src-onscroll="<?php echo e($__logo_url, false); ?>" loading="lazy"/></a>
            </div>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"><i class="ti-menu"></i></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav" style="letter-spacing: 1px;">
                    <li class="nav-item dropdown">
                        <a  href="<?php echo e(route('welcome'), false); ?>" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?php echo app('translator')->getFromJson('cms::lang.home'); ?></a>
                    </li>
                    <li class="nav-item"><a href="#" data-scroll-nav="1"><?php echo app('translator')->getFromJson('cms::lang.features'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="2"><?php echo app('translator')->getFromJson('cms::lang.how_it_work'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="3"><?php echo app('translator')->getFromJson('cms::lang.screenshots'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="4"><?php echo app('translator')->getFromJson('cms::lang.pricing'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="7"><?php echo app('translator')->getFromJson('cms::lang.reviews'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="6"><?php echo app('translator')->getFromJson('cms::lang.faqs'); ?></a></li>
                    <li class="nav-item"><a href="#" data-scroll-nav="8"><?php echo app('translator')->getFromJson('cms::lang.contact'); ?></a></li>
                    <?php if(Auth::check()): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('home'), false); ?>" class="hero-nav__link">
                                <strong>
                                    <?php echo app('translator')->getFromJson('cms::lang.dashboard'); ?>
                                </strong>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(Route::has('login') && ! Auth::check()): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('login') . '?lang=' . app()->getLocale(), false); ?>" class="hero-nav__link">
                                <strong>
                                    <?php echo app('translator')->getFromJson('lang_v1.login'); ?>
                                </strong>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(! Auth::check()): ?>
                        <li class="nav-item">
                            <a href="<?php echo e(route('register') . '?lang=' . app()->getLocale(), false); ?>" target="_blank" class="hero-nav__link"><?php echo app('translator')->getFromJson('cms::lang.register'); ?></a>
                        </li>    
                    <?php endif; ?>
                    <?php if(app()->getLocale() == 'en'): ?>
                        <li class="nav-item">
                            <a class="hero-nav__link" href="<?php echo e(route('welcome.lang','ar'), false); ?>">AR</a>
                        </li>    
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="hero-nav__link" href="<?php echo e(route('welcome.lang','en'), false); ?>">EN</a>
                        </li>    
                    <?php endif; ?>
                </ul>
            </div>
        </div>            
    </nav>
</header><?php /**PATH F:\ERPTEC_REFACTORY_5.8\Modules\Cms\Providers/../Resources/views/frontend/layouts/navbar.blade.php ENDPATH**/ ?>