<?php

return [
    'app' => [
        'name' => env('APP_NAME', 'Laravel'),
        'version' => 'v1.0.0',
        'copyright' => '2022 All Rights Reserved',
    ],

    'company' => [
        'key'           => 'hsse-ap2b-kal',
        'name'          => 'HSSE AP2B KALIMANTAN',
        'phone'         => '(021) 568 1111',
        'address'       => 'Jl. Letjen S. Parman Kav 87 Slipi, Jakarta Barat 11420',
    ],

    'logo' => [
        'favicon'       => 'assets/media/logos/pjnhk-favicon.ico',
        'auth'          => 'assets/media/logos/pjnhk-logo-auth.png',
        'aside'         => 'assets/media/logos/pjnhk-logo-aside.png',
        'print'         => 'assets/media/logos/pjnhk-logo-print.jpg',
        'hsse-ap2b-kal' => 'assets/media/logos/logo-pln.png',
        'pjnhk'         => 'assets/media/logos/logo-pjnhk.png',
        'kemenkes'      => 'assets/media/logos/logo-kemenkes.png',
        'barcode'       => 'assets/media/logos/pjnhk-logo-barcode.jpg',
    ],

    'mail' => [
        'send' => env('MAIL_SEND_STATUS', false),
        'logo' => 'https://pragmainf.co.id/themes/pragmaweb/assets/images/logo.png',
    ],

    'custom-menu' => true,
];
