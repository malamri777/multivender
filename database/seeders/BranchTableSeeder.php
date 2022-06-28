<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Branch;
use App\Models\User;

class BranchTableSeeder extends Seeder
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
            'name' => 'r1_b1_admin',
            'email' => 'r1_b1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 1 Restaurant 1',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);

        $admin = User::create([
            'name' => 'r1_b2_admin',
            'email' => 'r1_b2_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 2 Restaurant 1',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        $admin = User::create([
            'name' => 'r1_b3_admin',
            'email' => 'r1_b3_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 3 Restaurant 1',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 1,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);

        // 2 => almunajem
        $admin = User::create([
            'name' => 'r2_b1_admin',
            'email' => 'r2_b1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 1 Restaurant 2',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);

        $admin = User::create([
            'name' => 'r2_b2_admin',
            'email' => 'r2_b2_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 2 Restaurant 2',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        $admin = User::create([
            'name' => 'r2_b3_admin',
            'email' => 'r2_b3_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 3 Restaurant 2',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);
        Branch::create([
            'name'           => 'Branch 3 Restaurant 2',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 2,
            'country_id'    => 1,
            'state_id'    => 2,
            'city_id'    => 2,
            'district_id'    => 3,
        ]);

        // 3 => almunajem
        $admin = User::create([
            'name' => 'r3_b1_admin',
            'email' => 'r3_b1_admin@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_branch_admin',
            'email_verified_at' => now()
        ]);
        Branch::create([
            'name'           => 'Branch 1 Restaurant 3',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 1,
        ]);

        Branch::create([
            'name'           => 'Branch 2 Restaurant 3',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 2,
        ]);

        Branch::create([
            'name'           => 'Branch 3 Restaurant 3',
            'admin_id'    => $admin->id,
            'restaurant_id'    => 3,
            'country_id'    => 1,
            'state_id'    => 1,
            'city_id'    => 1,
            'district_id'    => 3,
        ]);
    }
}