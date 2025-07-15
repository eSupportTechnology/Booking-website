<?php
// config/domains.php
return [
    // ← typo here:
    // 'bookintour.com' => [ … ],
    // 'www.bookintour.com' => [ … ],

    // to the correct spelling:
    'bookingtour.com'     => [
        'type'  => 'text',
        'label' => 'Bookingtour.com',
    ],
    'www.bookingtour.com' => [
        'type'  => 'text',
        'label' => 'Bookingtour.com',
    ],

    'inselor.de'          => [
        'type' => 'image',
        'src'  => 'images/inselor-logo.png',
    ],
    'www.inselor.de'      => [
        'type' => 'image',
        'src'  => 'images/inselor-logo.png',
    ],

    // ... your localhost/dev entries
];
