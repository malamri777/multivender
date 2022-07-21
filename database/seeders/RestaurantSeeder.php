<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Restaurant;
use App\Models\User;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // restaurant 1
        $admin = User::create([
            'name' => 'r1_admin',
            'email' => 'r1_admin@dev.com',
            'phone' => '111111110',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_admin',
            'email_verified_at' => now(),
            'restaurant_id' => 1
        ]);
        $restaurant = Restaurant::create([
            'id' => 1,
            'name' => 'Restaurant 1',
            'cr_no' => '222222',
            'vat_no' => '222222',
            'email' => 'info@r1.com',
            'phone' => '22222211',
            'contact_user' => 'Restaurant 1 User1',
            'description' => 'description escriptiondescripti ondescr iption',
            'content' => 'conte ntcont  entconte ntcontent',
            'logo' => 1,
            'status' => 1,
            'admin_id'    => $admin->id,
            'cr_file'    => 5,
            'vat_file'    => 5,
        ]);
        $admin->restaurant_id = $restaurant->id;
        $admin->save();

        // restaurant 2
        $admin = User::create([
            'name' => 'r2_admin',
            'email' => 'r2_admin@dev.com',
            'phone' => '111111111',
            'password' => bcrypt('password'),
            'user_type' => 'restaurant_admin',
            'email_verified_at' => now(),
            'restaurant_id' => 2

        ]);
        $restaurant = Restaurant::create([
            'id' => 2,
            'name' => 'Restaurant 2',
            'cr_no' => '333333333',
            'vat_no' => '333333333',
            'email' => 'info@r2.com',
            'phone' => '333333333',
            'contact_user' => 'Restaurant 2 User1',
            'description' => 'descriptio ndescripti ondesc rip tionde sc ription',
            'content' => 'contentcon tentcont entcontent',
            'logo' => 2,
            'status' => 1,
            'admin_id'    => $admin->id,
            'cr_file'    => 5,
            'vat_file'    => 5,
        ]);
        $admin->restaurant_id = $restaurant->id;
        $admin->save();

        // restaurant 3
        Restaurant::create([
            'id' => 3,
            'name' => 'Restaurant 3',
            'cr_no' => '444444444',
            'vat_no' => '444444444',
            'email' => 'info@r3.com',
            'phone' => '444444444',
            'contact_user' => 'Restaurant 3 User1',
            'description' => 'descriptiondescriptiondescriptiondescription',
            'content' => 'contentcontentcontentcontent',
            'logo' => 3,
            'status' => 1,
            'cr_file'    => 5,
            'vat_file'    => 5,
        ]);

        // restaurant 4
        Restaurant::create([
            'id' => 4,
            'name' => 'Restaurant 4',
            'cr_no' => '55555555',
            'vat_no' => '55555555',
            'email' => 'info@r4.com',
            'phone' => '55555555',
            'contact_user' => 'Restaurant 4 User2',
            'description' => 'description descripti ondescri ption descri ption',
            'content' => 'contentco ntentconten tcontent',
            'logo' => 4,
            'status' => 1,
            'cr_file'    => 5,
            'vat_file'    => 5,
        ]);

    }
}
