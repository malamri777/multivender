<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            BusinessSettingTableSeeder::class,
            OTPTableSeeder::class,
            LanguageTableSeeder::class,
            SetupTableSeeder::class,
            TranslationTableSeeder::class,
            RoleTableSeeder::class,
            AddonTableSeeder::class,
//            LaratrustSeeder::class,
            UsersTableSeeder::class,


            SupplierSeeder::class,
            WarehouseTableSeeder::class,
            // Upload
            UploadTableSeeder::class,

            // Product
            CategoryTableSeeder::class,
            BrandTableSeeder::class,
            ProductTableSeeder::class,

            // Page
            PageTableSeeder::class,

            // Restaurant
            RestaurantSeeder::class,
            BranchTableSeeder::class,
        ]);

    }
}
