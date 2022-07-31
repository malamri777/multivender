<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BusinessSettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = base_path() . '/database/seeders/data/BusinessSetting.json';
        $settings = json_decode(file_get_contents($path), true);
        foreach($settings['business_settings'] as $setting) {
            BusinessSetting::create($setting);
        }
    }
}
