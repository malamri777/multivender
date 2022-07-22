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
        $path = base_path() . '/database/seeders/sql/Translation.sql';
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        $t = [
            [
                'id'    => 25137,
                'lang' => 'en',
                'lang_key' => 'shipping_districts',
                'lang_value' => 'Shipping Districts'
            ],
            [
                'id'    => 25138,
                'lang' => 'ar',
                'lang_key' => 'shipping_districts',
                'lang_value' => 'مناطق الشحن'
            ],
            [
                'id'    => 25139,
                'lang' => 'en',
                'lang_key' => 'districts',
                'lang_value' => 'Districts'
            ],
            [
                'id'    => 25140,
                'lang' => 'ar',
                'lang_key' => 'districts',
                'lang_value' => 'المناطق'
            ]
        ];

        Translation::insert($t);
    }
}
