<?php

return [
    /**
     * Control if the seeder should create a user per role while seeding the data.
     */
    'create_users' => false,

    /**
     * Control if all the laratrust tables should be truncated before running the seeder.
     */
    'truncate_tables' => true,

    'roles_structure' => [
        'super_admin' => [
            'admin_dashboard' => 'v',
            'profile' => 'r,u',
            'users' => 'c,r,u,d,l',
            'suppliers' => 'c,r,u,d,l',
            'supplier_dashboard' => 'v',
            'restaurants' => 'c,r,u,d,l',
            'pos' => 'r,l',
            'products' => 'c,r,u,d,l',
            'delivers' => 'c,r,u,d,l',
            'sales' => 'c,r,u,d,l',
            'refunds' => 'c,r,u,d,l',
            'admin_uploads' => 'c,r,u,d,l',
            'supplier_uploads' => 'c,r,u,d,l',
            'reports' => 'c,r,u,d,l',
            'blogs' => 'c,r,u,d,l',
            'marketings' => 'c,r,u,d,l',
            'supports' => 'c,r,u,d,l',
            'otps' => 'c,r,u,d,l',
            'setups' => 'c,r,u,d,l',
            'infos' => 'c,r,u,d,l',
            'addons' => 'c,r,u,d,l',

        ],
        'admin' => [
            'users' => 'c,r,u,d,l',
            'admin_dashboard' => 'v',
            'profile' => 'r,u'
        ],
        'supplier' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'supplier_uploads' => 'c,r,u,d,l',
        ],
        'supplier_admin' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'supplier_uploads' => 'c,r,u,d,l',
        ],
        'supplier_warehouse_admin' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'supplier_uploads' => 'c,r,u,d,l',
        ],

        'supplier_warehouse_driver' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'supplier_uploads' => 'c,r,u,d,l',
        ],


        'supplier_warehouse_user' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'supplier_uploads' => 'c,r,u,d,l',
        ],



        'restaurant' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'restaurant_uploads' => 'c,r,u,d,l',
        ],

        'restaurant_admin' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'restaurant_uploads' => 'c,r,u,d,l',
        ],
        'restaurant_branch_admin' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'restaurant_uploads' => 'c,r,u,d,l',
        ],
        'restaurant_branch_driver' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'restaurant_uploads' => 'c,r,u,d,l',
        ],
        'restaurant_branch_user' => [
            'profile' => 'r,u',
            'admin_dashboard' => 'v',
            'branch_uploads' => 'c,r,u,d,l',
        ],
        // 'driver' => [
        //     'profile' => 'r,u',
        //     'admin_dashboard' => 'v',
        //     'supplier_uploads' => 'c,r,u,d,l',
        // ],
        // 'role_name' => [
        //     'module_1_name' => 'c,r,u,d',
        // ]
    ],

    'permissions_map' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
        'l' => 'link',
        'v' => 'view'
    ]
];
