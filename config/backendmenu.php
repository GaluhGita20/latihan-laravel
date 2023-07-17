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
                'name' => 'master.geo',
                'title' => 'Geografis',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.geo.province',
                        'title' => 'Provinsi',
                        'url' => '/master/geo/province'
                    ],
                    [
                        'name' => 'master.geo.city',
                        'title' => 'Kota',
                        'url' => '/master/geo/city'
                    ],
                ]
            ],
            [
                'name' => 'master.pendidikan',
                'title' => 'Pendidikan',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.pendidikan.pendidikan',
                        'title' => 'Pendidikan',
                        'url' => '/master/pendidikan/pendidikan'
                    ],
                    [
                        'name' => 'master.pendidikan.jurusan',
                        'title' => 'Jurusan',
                        'url' => '/master/geo/city'
                    ],
                ]
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
