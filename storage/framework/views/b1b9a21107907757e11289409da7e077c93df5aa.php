<?php if($__is_essentials_enabled && $is_employee_allowed): ?>
	<button 
		type="button" 
		class="btn bg-blue btn-flat 
		pull-left m-8 btn-sm mt-10 
		clock_in_btn
		<?php if(!empty($clock_in)): ?>
	    	hide
	    <?php endif; ?>
		"
	    data-type="clock_in"
	    data-toggle="tooltip"
	    data-placement="bottom"
	    title="<?php echo app('translator')->getFromJson('essentials::lang.clock_in'); ?>" 
	    >
	    <i class="fas fa-arrow-circle-down"></i>
	</button>

	<button 
		type="button" 
		class="btn bg-yellow btn-flat pull-left m-8 
		 btn-sm mt-10 clock_out_btn
		<?php if(empty($clock_in)): ?>
	    	hide
	    <?php endif; ?>
		" 	
	    data-type="clock_out"
	    data-toggle="tooltip"
	    data-placement="bottom"
	    data-html="true"
	    title="<?php echo app('translator')->getFromJson('essentials::lang.clock_out'); ?> <?php if(!empty($clock_in)): ?>
                    <br>
                    <small>
                    	<b><?php echo app('translator')->getFromJson('essentials::lang.clocked_in_at'); ?>:</b> <?php echo e(\Carbon::createFromTimestamp(strtotime($clock_in->clock_in_time))->format(session('business.date_format') . ' ' . 'H:i'), false); ?>

                    </small>
                    <br>
                    <small><b><?php echo app('translator')->getFromJson('essentials::lang.shift'); ?>:</b> <?php echo e(ucfirst($clock_in->shift_name), false); ?></small>
                    <?php if(!empty($clock_in->start_time) && !empty($clock_in->end_time)): ?>
                    	<br>
                    	<small>
                    		<b><?php echo app('translator')->getFromJson('restaurant.start_time'); ?>:</b> <?php echo e(\Carbon::createFromTimestamp(strtotime($clock_in->start_time))->format('H:i'), false); ?><br>
                    		<b><?php echo app('translator')->getFromJson('restaurant.end_time'); ?>:</b> <?php echo e(\Carbon::createFromTimestamp(strtotime($clock_in->end_time))->format('H:i'), false); ?>

                    	</small>
                    <?php endif; ?>
                <?php endif; ?>" 
	    >
	    <i class="fas fa-hourglass-half fa-spin"></i>
	</button>
<?php endif; ?><?php /**PATH F:\ERPTEC_REFACTORY_5.8\Modules\Essentials\Providers/../Resources/views/layouts/partials/header_part.blade.php ENDPATH**/ ?>