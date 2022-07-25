<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Translations\Entities\Translation;

class TranslationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        $path = base_path() . '/database/seeders/sql/Translation.sql';
//        $sql = file_get_contents($path);
//        DB::unprepared($sql);

        $translationsJson = json_decode(file_get_contents(app_path() . "/../database/seeders/data/translations.json"), true);
        foreach ($translationsJson as $t) {
            Translation::create($t);
        }

        $t = [
            [
                'lang' => 'en',
                'lang_key' => 'shipping_districts',
                'lang_value' => 'Shipping Districts'
            ],
            [
                'lang' => 'ar',
                'lang_key' => 'shipping_districts',
                'lang_value' => 'مناطق الشحن'
            ],
            [
                'lang' => 'en',
                'lang_key' => 'districts',
                'lang_value' => 'Districts'
            ],
            [
                'lang' => 'ar',
                'lang_key' => 'districts',
                'lang_value' => 'المناطق'
            ]
        ];

        Translation::insert($t);
    }
}
