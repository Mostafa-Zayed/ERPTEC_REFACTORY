<?php $request = app('Illuminate\Http\Request'); ?>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" integrity="sha512-HK5fgLBL+xu6dm/Ii3z4xhlSUyZgTT9tuc/hSrtw6uzJOvgRr2a9jyxxT1ely+B+xFAmJKVSTbpM/CuL7qxO8w==" crossorigin="anonymous">
<!-- Main Header -->
<!--tag manager here-->
<script src="https://kit.fontawesome.com/294faa75f4.js" crossorigin="anonymous"></script>

  <header class="main-header no-print">
    <!-- Start New Navbar -->
    <div class="main-top-nav d-flex align-items-start align-items-md-center justify-content-md-between flex-column flex-md-row">
        
        <!-- Start Right Side -->
        <div class="d-flex align-items-center justify-content-between top-nav-logo"> 
            <div class="sidebar-btn mx-2">
                <img src="<?php echo e(asset('new_assets/images/elements-icons-menu.svg'), false); ?>" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            </div>
            <!-- Start Subscribtion Plan Info -->
            
            <?php if(Module::has('Superadmin')): ?>
                
                <?php if ($__env->exists('superadmin::layouts.partials.active_subscription')) echo $__env->make('superadmin::layouts.partials.active_subscription', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
            <!-- End Subscribtion Plan -->
            
            <!-- Start Attendance Registeration -->
	        <?php if(Module::has('Essentials')): ?>
                <?php if ($__env->exists('essentials::layouts.partials.header_part')) echo $__env->make('essentials::layouts.partials.header_part', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
	        <!-- End Attendance Registeration -->
	        
	        <!-- Start Languages -->
	        <?php
                $config_languages = config('constants.langs');
                $languages = [];
                foreach ($config_languages as $key => $value) {
                    $languages[$key] = $value['full_name'];
                }
                $user_id  = request()->session()->get('user.id');
                $usr  =  App\User::where('id', $user_id)->first();
            ?>
            <select name="language" class="lang language selectors ">
                <?php $__currentLoopData = $languages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$language): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                    <option value="<?php echo e(route('home.lang',$key), false); ?>"  <?php echo e(!empty($usr->language)  ?  ($usr->language == $key)  ? "selected" : ""   : "", false); ?>><?php echo e($language, false); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <!-- End Languages -->
            
            <!-- Clear Cache -->
            <a href="<?php echo e(route('cache-clear'), false); ?>" class="icon-container d-flex align-items-center justify-content-center" title="<?php echo app('translator')->getFromJson('lang_v1.clear_cache'); ?>" data-toggle="tooltip" data-placement="bottom">
                <i class="fas fa-broom"></i>
            </a>
        </div>
        <!-- End Right Side -->
        
        <!-- Start Left Side -->
        <div class="d-flex align-items-center">
            
            <!-- Start Register Details -->
            
            <!-- End Register Details -->
            
            <!-- Start Sale POS -->
            <?php if( auth()->user()->can('superadmin')): ?>
                <?php if(in_array('pos_sale', $enabled_modules)): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sell.create')): ?>
                        <a href="<?php echo e(action('SellPosController@create'), false); ?>" class="icon-container d-flex align-items-center justify-content-center" 
                            title="<?php echo app('translator')->getFromJson('sale.pos_sale'); ?>" data-toggle="tooltip" data-placement="bottom" class="btn btn-success btn-flat pull-left hidden-xs btn-sm">
                            <i class="fas fa-shopping-cart"></i>
                        </a>
                    <?php endif; ?>
                <?php endif; ?>
            <?php else: ?>
                <?php
                    $business_id = request()->session()->get('user.business_id');
                    $package = \Modules\Superadmin\Entities\Subscription::active_subscription($business_id);
                ?>
                <?php if(!empty($package)): ?>
                    <?php
                        $pack  = \Modules\Superadmin\Entities\Package::where('id',$package->package_id)->first();
                    ?>
                    <?php if(!empty($pack)): ?> 
                        <?php if(!empty($pack['custom_permissions']['online_module'])): ?> 
                            <?php if($pack['custom_permissions']['online_module'] == 1 ): ?> 
                                <?php if(in_array('pos_sale', $enabled_modules)): ?>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('sell.create')): ?>
                                        <a href="<?php echo e(action('SellPosController@create'), false); ?>" class="icon-container d-flex align-items-center justify-content-center"
                                            title="<?php echo app('translator')->getFromJson('sale.pos_sale'); ?>" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fas fa-shopping-cart"></i>
                                        </a>
                                    <?php endif; ?>
                                <?php endif; ?>  
                            <?php endif; ?>  
                        <?php endif; ?>  
                    <?php endif; ?>  
                <?php endif; ?>
            <?php endif; ?>
            <!-- End Sale POS -->
            
            <!-- Start Retail Sale POS -->
            <?php if(in_array('pos_sale', $enabled_modules)): ?>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(['retail.create','retail.view'])): ?>
                    
                <?php endif; ?>
            <?php endif; ?>
            <!-- End Retail Sale POS -->
            
            <?php echo $__env->make('layouts.partials.header-notifications', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="separator"></div>
            <div class="dropdown" style="margin-left:5px;">
                <button class="dropdown-toggle profile-toggle" type="button" id="dropdownMenuButton1" data-toggle="dropdown" aria-expanded="false">
                    <?php if(!empty(Session::get('business.logo'))): ?>
                        <img src="<?php echo e(url( 'public/uploads/business_logos/' . Session::get('business.logo') ), false); ?>" class="avatar">
                    <?php endif; ?>
                    <span><?php echo e(Auth::User()->first_name, false); ?></span>
                </button>    
                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                    <a class="dropdown-item" href="<?php echo e(action('UserController@getProfile'), false); ?>"><?php echo app('translator')->getFromJson('lang_v1.profile'); ?></a>
                    <a class="dropdown-item" href="<?php echo e(action('Auth\LoginController@logout'), false); ?>"><?php echo app('translator')->getFromJson('lang_v1.sign_out'); ?></a>
                </div>
            </div>        
        </div>    
    </div>      
    <!-- End New Navbar -->  
  </header><?php /**PATH F:\ERPTEC_REFACTORY_5.8\resources\views/layouts/partials/header.blade.php ENDPATH**/ ?>