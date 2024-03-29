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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],
    
    // 'sparkpost' => [
    //     'secret' => env('SPARKPOST_SECRET'),
    //     // optional guzzle specific configuration
    //     'guzzle' => [
    //         'verify' => true,
    //         'decode_content' => true,
    //     ],
    //     'options' => [
    //         // configure endpoint, if not default
    //         'endpoint' => env('SPARKPOST_ENDPOINT'),
    
    //         // optional Sparkpost API options go here
    //         'return_path' => 'mail@fraseteca.com.br',
    //         'options' => [
    //             'open_tracking' => false,
    //             'click_tracking' => false,
    //             'transactional' => true,
    //         ],
    //     ],
    // ],


    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

];
