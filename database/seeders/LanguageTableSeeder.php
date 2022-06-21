<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LanguageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'name' => 'English',
            'code' => 'en',
            'app_lang_code' => 'en',
            'rtl' => 0,
            'status' => true
        ]);

        Language::create([
            'name' => 'Arabic',
            'code' => 'sa',
            'app_lang_code' => 'ar',
            'rtl' => 1,
            'status' => true
        ]);
    }
}
