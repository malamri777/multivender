<?php

namespace Database\Seeders;

use App\Models\BusinessSetting;
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
        $path = base_path() . '/database/seeders/sql/BusinessSetting.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
