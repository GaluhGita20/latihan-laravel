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
                        'name' => 'master.org.unit',
                        'title' => 'Unit Pelaksana',
                        'url' => '/master/org/unit',
                    ],
                    [
                        'name' => 'master.org.bagian',
                        'title' => 'Bagian',
                        'url' => '/master/org/bagian',
                    ],
                    [
                        'name' => 'master.org.subbagian',
                        'title' => 'Subbagian',
                        'url' => '/master/org/subbagian',
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
                'name' => 'master.aset',
                'title' => 'Aset',
                'url' => '/master/aset',
            ],
            [
                'name' => 'master.kondisi-aset',
                'title' => 'Kondisi Aset',
                'url' => '/master/kondisi-aset',
            ],
            [
                'name' => 'master.team',
                'title' => 'Team/Group',
                'url' => '/master/team',
            ],
            [
                'name' => 'master.prioritas-aset',
                'title' => 'Prioritas Aset',
                'url' => '/master/prioritas-aset',
            ],
            [
                'name' => 'master.tipe-maintenance',
                'title' => 'Tipe Maintenance',
                'url' => '/master/tipe-maintenance',
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
