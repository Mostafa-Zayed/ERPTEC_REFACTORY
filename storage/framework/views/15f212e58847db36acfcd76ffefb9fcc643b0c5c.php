<table class="table table-bordered table-striped" id="stock_report_table">
    <thead>
        <tr>
            <th>SKU</th>
            <th><?php echo app('translator')->getFromJson('business.product'); ?></th>
            <th><?php echo app('translator')->getFromJson('sale.location'); ?></th>
            <th><?php echo app('translator')->getFromJson('sale.unit_price'); ?></th>
            <th><?php echo app('translator')->getFromJson('report.current_stock'); ?></th>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_stock_value')): ?>
            <th class="stock_price"><?php echo app('translator')->getFromJson('lang_v1.total_stock_price'); ?> <br><small>(<?php echo app('translator')->getFromJson('lang_v1.by_purchase_price'); ?>)</small></th>
            <th><?php echo app('translator')->getFromJson('lang_v1.total_stock_price'); ?> <br><small>(<?php echo app('translator')->getFromJson('lang_v1.by_sale_price'); ?>)</small></th>
            <th><?php echo app('translator')->getFromJson('lang_v1.potential_profit'); ?></th>
            <?php endif; ?>
            <th><?php echo app('translator')->getFromJson('report.total_unit_sold'); ?></th>
            <th><?php echo app('translator')->getFromJson('lang_v1.total_unit_transfered'); ?></th>
            <th><?php echo app('translator')->getFromJson('lang_v1.total_unit_adjusted'); ?></th>
            <?php if($show_manufacturing_data): ?>
                <th class="current_stock_mfg"><?php echo app('translator')->getFromJson('manufacturing::lang.current_stock_mfg'); ?> <?php
                if(session('business.enable_tooltip')){
                    echo '<i class="fa fa-info-circle text-info hover-q no-print " aria-hidden="true" 
                    data-container="body" data-toggle="popover" data-placement="auto bottom" 
                    data-content="' . __('manufacturing::lang.mfg_stock_tooltip') . '" data-html="true" data-trigger="hover"></i>';
                }
                ?></th>
            <?php endif; ?>
        </tr>
    </thead>
    <tfoot>
        <tr class="bg-gray font-17 text-center footer-total">
            <td colspan="4"><strong><?php echo app('translator')->getFromJson('sale.total'); ?>:</strong></td>
            <td class="footer_total_stock"></td>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('view_product_stock_value')): ?>
            <td class="footer_total_stock_price"></td>
            <td class="footer_stock_value_by_sale_price"></td>
            <td class="footer_potential_profit"></td>
            <?php endif; ?>
            <td class="footer_total_sold"></td>
            <td class="footer_total_transfered"></td>
            <td class="footer_total_adjusted"></td>
            <?php if($show_manufacturing_data): ?>
                <td class="footer_total_mfg_stock"></td>
            <?php endif; ?>
        </tr>
    </tfoot>
</table><?php /**PATH F:\ERPTEC_REFACTORY_5.8\resources\views/report/partials/stock_report_table.blade.php ENDPATH**/ ?>