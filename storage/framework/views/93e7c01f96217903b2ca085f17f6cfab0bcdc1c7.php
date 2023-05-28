<!DOCTYPE html>
<html lang="<?php echo e(app()->getLocale(), false); ?>">
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token(), false); ?>">
    <link rel="icon" href="<?php echo e(asset('public/website/images/logo_test.png'), false); ?>">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'ERP TEC'), false); ?></title> 
    <link rel="stylesheet" href="<?php echo e(asset('public/front/vendor/bootstrap/css/bootstrap.min.css'), false); ?> ">
    <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet">
    
    <?php echo $__env->make('layouts.partials.css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" href="<?php echo e(asset('public/css/style-v1.css'), false); ?>">
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style>
            body {
                /*background-color: #243949;*/
                background-color: #6622D5;
            }
            h1 {
                color: #fff;
            }
    </style>
</head>
<script src="https://kit.fontawesome.com/294faa75f4.js" crossorigin="anonymous"></script>
<body class="hold-transition">
    <?php if(session('status')): ?>
        <input type="hidden" id="status_span" data-status="<?php echo e(session('status.success'), false); ?>" data-msg="<?php echo e(session('status.msg'), false); ?>">
    <?php endif; ?>

    <?php if(!isset($no_header)): ?>
        <?php echo $__env->make('layouts.partials.header-auth', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <?php echo $__env->yieldContent('content'); ?>
    
    <?php echo $__env->make('layouts.partials.javascripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Scripts -->
    <script src="<?php echo e(asset('public/js/login.js?v=' . $asset_v), false); ?>"></script>
    <?php echo $__env->yieldContent('javascript'); ?>

    <script type="text/javascript">
        $(document).ready(function(){
            $('.select2_register').select2();

            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html><?php /**PATH /home/u521976387/domains/erptec.net/public_html/erp/resources/views/layouts/auth.blade.php ENDPATH**/ ?>