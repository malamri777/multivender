<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'admin',
            'permissions' => '["1","2","3","4","5","6","8","9",10",11",12",13",14",20",21",22",23","24"]'
        ]);

        Role::create([
            'name' => 'manager',
            'permissions' => '["1","2","4"]'
        ]);

        Role::create([
            'name' => 'accountant',
            'permissions' => '["2","3"]'
        ]);
    }
}
