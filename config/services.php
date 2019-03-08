<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],
        'facebook' => [
        'client_id' => '512517055892550',
        'client_secret' => '72db37ae90667c433e6a80b7b4410494',
        'redirect' => 'https://situr2-luifer.c9users.io/registrar/handleprovidercallback/facebook'
    ],
    'google' => [
        'client_id' => '224096646786-023pr43kve1duiehrjmfi2ma17cj48cq.apps.googleusercontent.com',
        'client_secret' => 'eBvULZCNMJ0zAiASmHMwlUoq',
        'redirect' => 'https://situr2-luifer.c9users.io/registrar/handleprovidercallback/google'
    ]

];
