<?php if( in_array(session()->get('user.language', config('app.locale')), config('system.langRtl')) ): ?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.rtl.min.css">
<?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/new_assets/css/bootstrap.min.css'), false); ?>">
<?php endif; ?>


<?php if(!empty(session('business.theme_color')) && session('business.theme_color') == 'orange'): ?>
    <?php
        $theme = session('business.theme_color');
    ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/vendor_'.$theme.'.css'), false); ?>">
<?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/vendor.css?v='.$asset_v), false); ?>">
<?php endif; ?>

<?php if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ): ?>
	<link rel="stylesheet" href="<?php echo e(asset('public/css/rtl.css?v='.$asset_v), false); ?>">
<?php endif; ?>

<?php echo $__env->yieldContent('css'); ?>

<!-- app css -->
<link rel="stylesheet" href="<?php echo e(asset('public/css/app.css?v='.$asset_v), false); ?>">

<link rel="stylesheet" href="<?php echo e(asset('public/front/vendor/owl.carousel/assets/owl.carousel.min.css'), false); ?> ">
<link rel="stylesheet" href="<?php echo e(asset('public/front/vendor/owl.carousel/assets/owl.theme.default.min.css'), false); ?> ">

<?php if(isset($pos_layout) && $pos_layout): ?>
	<style type="text/css">
		.content{
			padding-bottom: 0px !important;
		}
	</style>
<?php endif; ?>

<?php if(!empty($__system_settings['additional_css'])): ?>
    <style type="text/css">
        <?php echo $__system_settings['additional_css']; ?>

    </style>
<?php endif; ?>

<link rel="stylesheet" href="<?php echo e(asset('public/new_assets/css/style.css'), false); ?>">

<?php if( in_array(session()->get('user.language', config('app.locale')), config('constants.langs_rtl')) ): ?>

    <link rel="stylesheet" href="<?php echo e(asset('public/new_assets/css/style-rtl.css'), false); ?> ">
<?php endif; ?>

<link rel="stylesheet" href="<?php echo e(asset('public/new_assets/css/custom.css'), false); ?> ">
<link rel="stylesheet" href="<?php echo e(asset('public/new_assets/css/responsive.css'), false); ?> ">
<?php /**PATH /home/u521976387/domains/erptec.net/public_html/erp/resources/views/layouts/partials/css.blade.php ENDPATH**/ ?>