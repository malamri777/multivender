<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'super_admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
        ]);

        $user = User::create([
            'name' => 'supplier1',
            'email' => 's1@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'seller'
        ]);
        $shop = Shop::create([

        ]);


        $user = User::create([
            'name' => 'rustorant',
            'email' => 'r1@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'customer'
        ]);

//        $user->attachRole('super_admin');

    }//end of run

}//end of seeder