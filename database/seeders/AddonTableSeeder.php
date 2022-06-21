<?php

namespace Database\Seeders;

use App\Models\Addon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddonTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Addon::create([
            'name' => 'Wholesale',
            "unique_identifier" => "wholesale",
            "version" => "1.0",
            "image" => "addons/wholesale.png",
            "activated" => 1,
            "purchase_code" => "lskdfjlsdkjf"
        ]);
    }
}
