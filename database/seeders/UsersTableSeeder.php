<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Factories\UserFactory;

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
            'phone' => '000000000',
            'password' => bcrypt('password'),
//            'user_type' => 'super_admin',
            'email_verified_at' => now()
        ]);

        $role = Role::where('name', 'super_admin')->first();
        $user->roles()->sync($role);

        $user = User::create([
            'name' => 'admin',
            'email' => 'admin@app.com',
            'phone' => '000000001',
            'password' => bcrypt('password'),
            'user_type' => 'admin',
            'email_verified_at' => now()
        ]);
        $role = Role::where('name', 'admin')->first();
        $user->roles()->sync($role);

        // Supplier 1
        $admin = User::create([
            'name' => 's1_admin',
            'email' => 's1_admin@dev.com',
            'phone' => '000000003',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_admin',
            'email_verified_at' => now()
        ]);
        $role = Role::where('name', 'supplier_admin')->first();
        $admin->roles()->sync($role);

        // Supplier 2
        $admin = User::create([
            'name' => 's2_admin',
            'email' => 's2_admin@dev.com',
            'phone' => '000000004',
            'password' => bcrypt('password'),
            'user_type' => 'supplier_admin',
            'email_verified_at' => now()
        ]);

        $role = Role::where('name', 'supplier_admin')->first();
        $admin->roles()->sync($role);

        $user = User::create([
            'name' => 'api_test',
            'email' => 'api_test@dev.com',
            'phone' => '5555555555',
            'password' => bcrypt('password'),
            'email_verified_at' => now()
        ]);

        $user->createToken('API Token')->plainTextToken;
        // \App\Models\User::factory(100)->create();

    }//end of run

}//end of seeder
