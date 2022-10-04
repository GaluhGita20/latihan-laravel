<?php

return [
    [
        'section' => 'NAVIGASI',
        'name' => 'navigasi',
        'perms' => 'dashboard',
    ],
    // Dashboard
    [
        'name' => 'dashboard',
        'perms' => 'dashboard',
        'title' => 'Dashboard',
        'icon' => 'fa fa-th-large',
        'url' => '/home',
    ],
    // Transaction: Example
    [
        'name' => 'example',
        'title' => 'Example',
        'icon' => 'fa fa-book',
        'submenu' => [
            [
                'name' => 'example.crud',
                'perms' => 'example.crud',
                'title' => 'Crud',
                'url' => '/example/crud',
            ],
        ]
    ],
    // Admin Console
    [
        'section' => 'ADMIN KONSOL',
        'name' => 'console.admin',
    ],
    [
        'name' => 'master',
        'perms' => 'master',
        'title' => 'Data Master',
        'icon' => 'fa fa-database',
        'submenu' => [
            [
                'name' => 'master.org',
                'title' => 'Struktur Organisasi',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.org.root',
                        'title' => 'Root',
                        'url' => '/master/org/root'
                    ],
                    [
                        'name' => 'master.org.bod',
                        'title' => 'Direksi',
                        'url' => '/master/org/bod'
                    ],
                    [
                        'name' => 'master.org.division',
                        'title' => 'Divisi',
                        'url' => '/master/org/division'
                    ],
                    [
                        'name' => 'master.org.department',
                        'title' => 'Departement',
                        'url' => '/master/org/department'
                    ],
                    [
                        'name' => 'master.org.position',
                        'title' => 'Jabatan',
                        'url' => '/master/org/position',
                    ],
                ]
            ],
            [
                'name' => 'master.example',
                'perms' => 'master.example',
                'title' => 'Example',
                'url' => '/master/example',
            ],
            [
                'name' => 'master.geo',
                'perms' => 'master.geo',
                'title' => 'Geografis',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.geo.province',
                        'perms' => 'master.geo.province',
                        'title' => 'Provinsi',
                        'url' => '/master/geo/province'
                    ],
                    [
                        'name' => 'master.geo.city',
                        'perms' => 'master.geo.city',
                        'title' => 'Kota',
                        'url' => '/master/geo/city'
                    ],
                    [
                        'name' => 'master.geo.district',
                        'perms' => 'master.geo.district',
                        'title' => 'Kecamatan',
                        'url' => '/master/geo/district'
                    ],
                ]
            ],
            [
                'name' => 'master.failure-code',
                'title' => 'Failure Code',
                'url' => '/master/failure-code',
            ],
        ]
    ],

    [
        'name' => 'setting',
        'perms' => 'setting',
        'title' => 'Pengaturan Umum',
        'icon' => 'fa fa-cogs',
        'submenu' => [
            [
                'name' => 'setting.role',
                'title' => 'Hak Akses',
                'url' => '/setting/role',
            ],
            [
                'name' => 'setting.flow',
                'title' => 'Flow Approval',
                'url' => '/setting/flow',
            ],
            [
                'name' => 'setting.user',
                'title' => 'Manajemen User',
                'url' => '/setting/user',
            ],
            [
                'name' => 'setting.activity',
                'title' => 'Audit Trail',
                'url' => '/setting/activity',
            ],
        ]
    ],
];
