<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Warehouse;
use App\Models\WarehouseProduct;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarehouseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // 1 => balubaid
        $admin = User::create([
            'name' => 's1_w1_admin',
            'email' => 's1_w1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 1
        ]);
        $user = User::create([
            'name' => 's1_w1_user',
            'email' => 's1_w1_user@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_user',
            'email_verified_at' => now(),
            'provider_id' => 1
        ]);
        $w1 = Warehouse::create([
            'name'           => 'WareHouse 1 balubaid',
            'admin_id'    => $admin->id,
            'supplier_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);
        $w1->warehouseUsers()->attach([$user->id]);

        $admin = User::create([
            'name' => 's1_w2_admin',
            'email' => 's1_w2_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 1
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 2 balubaid',
            'admin_id'    => $admin->id,
            'supplier_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        $admin = User::create([
            'name' => 's1_w3_admin',
            'email' => 's1_w3_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 1
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 3 balubaid',
            'admin_id'    => $admin->id,
            'supplier_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);

        // 2 => almunajem
        $admin = User::create([
            'name' => 's2_w1_admin',
            'email' => 's2_w1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 2
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 1 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);

        $admin = User::create([
            'name' => 's2_w2_admin',
            'email' => 's2_w2_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 2
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 2 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        $admin = User::create([
            'name' => 's2_w3_admin',
            'email' => 's2_w3_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 2
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 3 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 3 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 2,
            'city_id'    => 2,
            'district_id'    => 3,
        ]);

        // 3 => almunajem
        $admin = User::create([
            'name' => 's3_w1_admin',
            'email' => 's3_w1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_warehouse_admin',
            'email_verified_at' => now(),
            'provider_id' => 3
        ]);
        Warehouse::create([
            'name'           => 'WareHouse 1 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);

        Warehouse::create([
            'name'           => 'WareHouse 2 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        Warehouse::create([
            'name'           => 'WareHouse 3 almunajem',
            'admin_id'    => $admin->id,
            'supplier_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);

        WarehouseProduct::create([
            'price' => 20,
            'sale_price' => 2,
            'quantity' => 100,
            'warehouse_id' => 1,
            'product_id' => 1,
            'create_by_id' => 1,
            'updated_by_id' => 1,
            'sale_price_type' => 'percent',
            'sale_price_start_date' => '18-07-2022',
            'sale_price_end_date' => '20-07-2022',
            'low_stock_quantity' => 1,


        ]);
    }
}
