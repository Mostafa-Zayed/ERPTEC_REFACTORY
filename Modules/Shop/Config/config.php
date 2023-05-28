<?php

return [
    'name' => 'Shop ApI Integration',
    'module_version' => "1.0",
    'settings' => [
        'name' => '',
        'url' => '',
        'code' => '',
        'username' => '',
        'password' => '',
        'type' => 'admin',
        'secret' => '',
        'location_id' => null,
        'default_tax_class' => '',
        'product_tax_type' => 'inc',
        'default_selling_price_group' => '',
        'product_fields_for_create' => ['category', 'quantity'],
        'product_fields_for_update' => ['name', 'price', 'category', 'quantity'],
        'enable_auto_sync' => false,
    ],
    'alerts' => [
        'categories'=> [
            'create' => 0,
            'updated' => 0,
            'note' => 0,
            'error' => 0
        ],
        'variations' => [
            'create' => 0,
            'updated' => 0,
            'note' => 0,
            'error' => 0
        ],
        'brands' => [
            'create' => 0,
            'updated' => 0,
            'note' => 0,
            'error' => 0
        ],
        'products' => [
            'create' => 0,
            'updated' => 0,
            'note' => 0,
            'error' => 0
        ],
        'taxs' => [
            'create' => 0,
            'updated' => 0,
            'note' => 0,
            'error' => 0
        ],
    ],
];
