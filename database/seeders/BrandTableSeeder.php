<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Brand::create([
        //     'name' => 'Brand 1'
        // ]);

        $path = base_path() . '/database/seeders/data/Brand.json';
        $brands = json_decode(file_get_contents($path), true);
        foreach ($brands['brands'] as $brand) {
            Brand::create($brand);
        }
    }
}
