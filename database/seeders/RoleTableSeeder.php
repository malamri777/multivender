<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
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
        $user = User::find(1);
        $allRoles = Role::get()->pluck("id");
        $allPermissions = Permission::get()->pluck("id");
        $user->attachRoles($allRoles);
        $user->attachPermissions($allPermissions);

//        Role::create([
//            'name' => 'super_admin',
//            'permissions' => '[1,2,3,4,5,6,8,9,10,11,12,13,14,20,21,22,23,24,25]'
//        ]);
//
//        Role::create([
//            'name' => 'admin',
//            'permissions' => '[1,2,3,4,5,6,8,9,10,11,12,13,14,20,21,22,23,24,25]'
//        ]);
//
//        Role::create([
//            'name' => 'manager',
//            'permissions' => '[1,2,4]'
//        ]);
//
//        Role::create([
//            'name' => 'accountant',
//            'permissions' => '[2,3]'
//        ]);
    }
}
