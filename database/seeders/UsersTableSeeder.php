<?php

namespace Database\Seeders;

use App\Models\Shop;
use App\Models\User;
use Database\Factories\UserFactory;
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
            'user_type' => 'super_admin',
        ]);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
        ]);


        $user = User::create([
            'name' => 'rustorant',
            'email' => 'r1@dev.com',
            'password' => bcrypt('password'),
            'user_type' => 'customer'
        ]);

        \App\Models\User::factory(100)->create();

    }//end of run

}//end of seeder
