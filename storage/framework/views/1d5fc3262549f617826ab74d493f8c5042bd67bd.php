<?php $__env->startSection('title', __('lang_v1.register')); ?>


<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('public/new_assets/intlTelInput/css/intlTelInput.min.css'), false); ?>"/>
<div class="login-form col-md-12 col-xs-12 right-col-content-register">
    
    <p class="form-header text-white"><?php echo app('translator')->getFromJson('business.register_and_get_started_in_minutes'); ?></p>
    
    <?php echo Form::open(['url' => route('add-new_business'), 'method' => 'post', 
                            'id' => 'business_register_form','files' => true ]); ?>

                            
        <?php echo $__env->make('business2.partials.register_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php echo Form::hidden('package_id', $package_id);; ?>

        
    <?php echo Form::close(); ?>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('javascript'); ?>
<script type="text/javascript">
    $(document).ready(function(){
        
        /* change language */
        $('#change_lang').change( function(){
            window.location = "<?php echo e(route('register'), false); ?>?lang=" + $(this).val();
        });
        
        
        $(".time_zone").val("Africa/Cairo").change();
        $("#country").val("Egypt").change();
        $(".currency").val("35").change();
        
        $("Select[name='country']").change(function(){
            console.log('sdfd');
        });
    })
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth2', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH F:\ERPTEC_REFACTORY_5.8\resources\views/business2/register.blade.php ENDPATH**/ ?>