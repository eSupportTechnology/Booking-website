<?php

return [
    env('APP_DOMAIN') => [
        'type' => env('APP_DOMAIN_TYPE', 'text'),
        'label' => env('APP_DOMAIN_LABEL', 'Bookingtour.com'),
    ],
    'www.' . env('APP_DOMAIN') => [
        'type' => env('APP_DOMAIN_TYPE', 'text'),
        'label' => env('APP_DOMAIN_LABEL', 'Bookingtour.com'),
    ],

    env('INSELOR_DOMAIN') => [
        'type' => env('INSELOR_DOMAIN_TYPE', 'image'),
        'src'  => env('INSELOR_DOMAIN_SRC', 'images/inselor-logo.png'),
    ],
    'www.' . env('INSELOR_DOMAIN') => [
        'type' => env('INSELOR_DOMAIN_TYPE', 'image'),
        'src'  => env('INSELOR_DOMAIN_SRC', 'images/inselor-logo.png'),
    ],
];


