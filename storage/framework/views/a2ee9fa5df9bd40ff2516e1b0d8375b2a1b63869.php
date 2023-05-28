<section class="no-print">
    <nav class="navbar navbar-default bg-white m-4">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?php echo e(action('\Modules\Woocommerce\Http\Controllers\WoocommerceController@index'), false); ?>"><i class="fab fa-wordpress"></i> <?php echo e(__('woocommerce::lang.woocommerce'), false); ?></a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav" style="flex-direction: row;">
                    <li <?php if(request()->segment(1) == 'woocommerce' && request()->segment(2) == 'view-sync-log'): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Woocommerce\Http\Controllers\WoocommerceController@viewSyncLog'), false); ?>"><?php echo app('translator')->getFromJson('woocommerce::lang.sync_log'); ?></a></li>

                    <?php if(auth()->user()->can('woocommerce.access_woocommerce_api_settings')): ?>
                        <li <?php if(request()->segment(1) == 'woocommerce' && request()->segment(2) == 'api-settings'): ?> class="active" <?php endif; ?>><a href="<?php echo e(action('\Modules\Woocommerce\Http\Controllers\WoocommerceController@apiSettings'), false); ?>"><?php echo app('translator')->getFromJson('woocommerce::lang.api_settings'); ?></a></li>
                    <?php endif; ?>
                </ul>

            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
</section><?php /**PATH /home/u521976387/domains/erptec.net/public_html/erp/Modules/Woocommerce/Providers/../Resources/views/layouts/nav.blade.php ENDPATH**/ ?>