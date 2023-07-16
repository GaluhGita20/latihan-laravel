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
    // // Transaction: Example
    // [
    //     'name' => 'example',
    //     'title' => 'Example',
    //     'icon' => 'fa fa-book',
    //     'submenu' => [
    //         [
    //             'name' => 'example.crud',
    //             'perms' => 'example.crud',
    //             'title' => 'Crud',
    //             'url' => '/example/crud',
    //         ],
    //     ]
    // ],

    // PURCHASING
    [
        'name' => 'purchasing',
        'title' => 'Purchasing',
        'icon' => 'fa fa-tags',
        'submenu' => [
            [
                'name' => 'purchasing.purchase-order',
                'perms' => 'purchasing.purchase-order',
                'title' => 'Purchase Order',
                'url' => '/purchasing/purchase-order',
            ],
            [
                'name' => 'purchasing.good-receipt',
                'perms' => 'purchasing.good-receipt',
                'title' => 'Good Receipt',
                'url' => '/purchasing/good-receipt',
            ],
        ]
    ],

    // Rencana Pemeliharaan
    [
        'name' => 'rencana-pemeliharaan',
        'title' => 'Rencana Pemeliharaan',
        'icon' => 'fa fa-calendar',
        'submenu' => [
            [
                'name' => 'rencana-pemeliharaan.jadwal',
                'perms' => 'rencana-pemeliharaan.jadwal',
                'title' => 'Jadwal',
                'url' => '/rencana-pemeliharaan/jadwal',
            ],
            // [
            //     'name' => 'maintain.biaya',
            //     'perms' => 'maintain.biaya',
            //     'title' => 'Biaya',
            //     'url' => '/maint/biaya',
            // ],
        ]
    ],

    // Transaction: Work Management
    [
        'name' => 'work-manage',
        'title' => 'Work Management',
        'icon' => 'fas fa-swatchbook',
        'submenu' => [
            [
                'name' => 'work-manage.work-req',
                'perms' => 'work-manage.work-req',
                'title' => 'Work Request',
                'url' => '/work-manage/work-req',
            ],
            [
                'name' => 'work-manage.work-order',
                'perms' => 'work-manage.work-order',
                'title' => 'Work Order',
                'url' => '/work-order',
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
            // [
            //     'name' => 'master.example',
            //     'perms' => 'master.example',
            //     'title' => 'Example',
            //     'url' => '/master/example',
            // ],
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
                    // [
                    //     'name' => 'master.geo.district',
                    //     'perms' => 'master.geo.district',
                    //     'title' => 'Kecamatan',
                    //     'url' => '/master/geo/district'
                    // ],
                ]
            ],
            [
                'name' => 'master',
                'perms' => 'master',
                'title' => 'Struktur Aset',
                'url' => '',
                'submenu' => [
                    [
                        'name' => 'master.plant',
                        'title' => 'Plant',
                        'url' => '/master/plant',
                    ],
                    [
                        'name' => 'master.system',
                        'title' => 'System',
                        'url' => '/master/system',
                    ],
                    [
                        'name' => 'master.equipment',
                        'title' => 'Equipment',
                        'url' => '/master/equipment',
                    ],
                    [
                        'name' => 'master.sub-unit',
                        'title' => 'Sub Unit',
                        'url' => '/master/sub-unit',
                    ],
                    [
                        'name' => 'master.komponen',
                        'title' => 'Komponen',
                        'url' => '/master/komponen',
                    ],
                    [
                        'name' => 'master.parts',
                        'title' => 'Parts',
                        'url' => '/master/parts',
                    ],
                    // [
                    //     'name' => 'master.lokasi',
                    //     'title' => 'Lokasi',
                    //     'url' => '/master/lokasi',
                    // ],
                    // [
                    //     'name' => 'master.sub-lokasi',
                    //     'title' => 'System',
                    //     'url' => '/master/sub-lokasi',
                    // ],
                    // [
                    //     'name' => 'master.aset',
                    //     'title' => 'Aset',
                    //     'url' => '/master/aset',
                    // ],
                    // [
                    //     'name' => 'master.parts ',
                    //     'title' => 'Parts ',
                    //     'url' => '/master/parts ',
                    // ],
                    // [
                    //     'name' => 'master.assemblies',
                    //     'title' => 'Assemblies',
                    //     'url' => '/master/assemblies',
                    // ],
                ]
            ],
            [
                'name' => 'master.aset',
                'title' => 'Aset',
                'url' => '/master/aset',
            ],
            [
                'name' => 'master.tipe-aset',
                'title' => 'Tipe Aset',
                'url' => '/master/tipe-aset',
            ],
            [
                'name' => 'master.instruksi-kerja',
                'title' => 'Instruksi Kerja',
                'url' => '/master/instruksi-kerja',
            ],
            [
                'name' => 'master.failure-code',
                'title' => 'Failure Code',
                'url' => '/master/failure-code',
            ],
            [
                'name' => 'master.biaya-lain',
                'title' => 'Komponen Biaya',
                'url' => '/master/biaya-lain',
            ],
            [
                'name' => 'master.status-aset',
                'title' => 'Status Aset',
                'url' => '/master/status-aset',
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
                'name' => 'master.vendor-aset',
                'title' => 'Vendor',
                'url' => '/master/vendor-aset',
            ],
            [
                'name' => 'master.prioritas-aset',
                'title' => 'Prioritas',
                'url' => '/master/prioritas-aset',
            ],
            [
                'name' => 'master.tipe-maintenance',
                'title' => 'Tipe Pemeliharaan',
                'url' => '/master/tipe-maintenance',
            ],
            [
                'name' => 'master.item-pemeliharaan',
                'title' => 'Item Pemeliharaan',
                'url' => '/master/item-pemeliharaan',
            ],            
            [
                'name' => 'master.skillset',
                'title' => 'Skillset',
                'url' => '/master/skillset',
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
