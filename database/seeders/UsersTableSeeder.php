<?php

namespace Database\Seeders;

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
            'email' => 's1@app.com',
            'password' => bcrypt('password'),
        ]);

//        $user->attachRole('super_admin');

    }//end of run

}//end of seeder
