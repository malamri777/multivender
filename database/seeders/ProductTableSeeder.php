<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Attribute
        Attribute::create([
            'name' => 'Size'
        ]);
        AttributeTranslation::create([
            'attribute_id' => 1,
            'name' => 'حجم',
            'lang' => 'sa'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'Small'
        ]);
        AttributeValue::create([
            'attribute_id' => 1,
            'value' => 'Large'
        ]);


    }
}
