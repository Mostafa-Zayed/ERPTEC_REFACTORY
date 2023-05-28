<?php

return [
    'allowRegistration' => true,
    'cashier_roles' =>[
        'sell.view',
        'sell.create',
        'sell.update',
        'sell.delete',
        'access_all_locations',
        'view_cash_register',
        'close_cash_register'
    ],
    'themeColors' => [
        'blue' => 'Blue',
        'black' => 'Black',
        'purple' => 'Purple',
        'green' => 'Green',
        'red' => 'Red',
        'yellow' => 'Yellow',
        'blue-light' => 'Blue Light',
        'black-light' => 'Black Light',
        'purple-light' => 'Purple Light',
        'green-light' => 'Green Light',
        'red-light' => 'Red Light',
    ],
    'mailDrivers' => [
        'smtp' => 'SMTP',
        // 'sendmail' => 'Sendmail',
        // 'mailgun' => 'Mailgun',
        // 'mandrill' => 'Mandrill',
        // 'ses' => 'SES',
        // 'sparkpost' => 'Sparkpost'
    ],
    'date_formats' => [
        'd-m-Y' => 'dd-mm-yyyy',
        'm-d-Y' => 'mm-dd-yyyy',
        'd/m/Y' => 'dd/mm/yyyy',
        'm/d/Y' => 'mm/dd/yyyy'
    ],
    'cashier_role_default_permissions' => [
        'sell.view',
        'sell.create',
        'sell.update',
        'sell.delete',
        'access_all_locations',
        'view_cash_register',
        'close_cash_register'
    ],
    'settings' => [
        'name',
        'start_date',
        'tax_number_1',
        'tax_label_1',
        'tax_number_2',
        'tax_label_2'
    ],
    'default_date_format' => 'm/d/Y',
    'sell_price_tax' => 'includes',
    'default_profit_percent' => 25,
    'enable_inline_tax' => 0,
    'defaultPosSettings' =>[
        'disable_pay_checkout' => 0,
        'disable_draft' => 0,
        'disable_express_checkout' => 0,
        'hide_product_suggestion' => 0,
        'hide_recent_trans' => 0,
        'disable_discount' => 0,
        'disable_order_tax' => 0,
        'is_pos_subtotal_editable' => 0
    ],
    'defaultEmailSettings' => [
        'mail_host' => '',
        'mail_port' => '',
        'mail_username' => '',
        'mail_password' => '',
        'mail_encryption' => '',
        'mail_from_address' => '',
        'mail_from_name' => ''
    ],
    'defaultSmsSettings' => [
        'url' => '',
        'send_to_param_name' => 'to',
        'msg_param_name' => 'text',
        'request_method' => 'post',
        'param_1' => '',
        'param_val_1' => '',
        'param_2' => '',
        'param_val_2' => '',
        'param_3' => '',
        'param_val_3' => '',
        'param_4' => '',
        'param_val_4' => '',
        'param_5' => '',
        'param_val_5' => '',
    ],
    'enabled_modules' => [
        'purchases',
        'add_sale',
        'pos_sale',
        'stock_transfers',
        'stock_adjustment',
        'expenses',
        'account'
    ],
    'fy_start_month' => 1,
    'ref_no_prefixes' => [
        'purchase' => 'PO',
        'stock_transfer' => 'ST',
        'stock_adjustment' => 'SA',
        'sell_return' => 'CN',
        'expense' => 'EP',
        'contacts' => 'CO',
        'purchase_payment' => 'PP',
        'sell_payment' => 'SP',
        'business_location' => 'BL'
    ],
    'ref_count_model' => ['contacts', 'business_location', 'username'],
    'keyboard_shortcuts' => '{"pos":{"express_checkout":"shift+e","pay_n_ckeckout":"shift+p","draft":"shift+d","cancel":"shift+c","edit_discount":"shift+i","edit_order_tax":"shift+t","add_payment_row":"shift+r","finalize_payment":"shift+f","recent_product_quantity":"f2","add_new_product":"f4"}}',
];
