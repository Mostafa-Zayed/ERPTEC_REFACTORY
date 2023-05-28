<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, SparkPost and others. This file provides a sane default
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    'nexmo' => [
        'sms_from' => ''
    ],
    // 'paypal' => [
    //     'paypal_mode'                 => env('PAYPAL_MODE'),
    //     'sandbox_base_uri'            => env('PAYPAL_SANDBOX_BASE_URI'),
    //     'paypal_sandbox_api_username' => env('PAYPAL_SANDBOX_API_USERNAME'),
    //     'paypal_sandbox_api_password' => env('PAYPAL_SANDBOX_API_PASSWORD'),
    //     'paypal_sandbox_api_secret'   => env('PAYPAL_SANDBOX_API_SECRET'),
    //     'live_base_uri'               => env('PAYPAL_LIVE_BASE_URI'),
    //     'paypal_live_api_username'    => env('PAYPAL_LIVE_API_USERNAME'),
    //     'paypal_live_api_password'    => env('PAYPAL_LIVE_API_PASSWORD'),
    //     'paypal_live_api_sercret'     => env('PAYPAL_LIVE_API_SECRET')
    // ],

];
