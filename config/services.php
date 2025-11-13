<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Payment Gateway Services
    |--------------------------------------------------------------------------
    */

    'hitpay' => [
        'api_key' => env('HITPAY_API_KEY'),
        'salt' => env('HITPAY_SALT'),
        'sandbox' => env('HITPAY_SANDBOX', true),
        'enabled' => env('HITPAY_ENABLED', false),
    ],

    'stripe' => [
        'public_key' => env('STRIPE_PUBLIC_KEY'),
        'secret_key' => env('STRIPE_SECRET_KEY'),
        'webhook_secret' => env('STRIPE_WEBHOOK_SECRET'),
        'enabled' => env('STRIPE_ENABLED', false),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID'),
        'client_secret' => env('PAYPAL_CLIENT_SECRET'),
        'sandbox' => env('PAYPAL_SANDBOX', true),
        'enabled' => env('PAYPAL_ENABLED', false),
    ],

    'bank_transfer' => [
        'bank_name' => env('BANK_NAME') ?: 'DBS Bank',
        'account_name' => env('BANK_ACCOUNT_NAME') ?: 'Streams Of Life Pte Ltd',
        'account_number' => env('BANK_ACCOUNT_NUMBER') ?: '002-1234567-8',
        'swift_code' => env('BANK_SWIFT_CODE') ?: '21321',
        // 'branch_code' => env('BANK_BRANCH_CODE', ''), // Optional: Branch code
        // 'routing_number' => env('BANK_ROUTING_NUMBER', ''), // Optional: Routing number
        'iban' => env('BANK_IBAN', ''), // Optional: IBAN for international transfers
        'enabled' => env('BANK_TRANSFER_ENABLED', true),
    ],

];
