<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeTranslation;
use App\Models\AttributeValue;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Translations\Entities\ProductTranslation;

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

        // Product
        $product = Product::create([
            'name' => 'Product One',
            'user_id' => 1,
            'category_id' => 1,
            'brand_id' => 1,
            'description' => 'descriptiondescriptiondescription',
            'unit_price' => 500,
            'purchase_price' => 250,
            'cash_on_delivery' => true,
            'unit' => 1
        ]);
        ProductTranslation::create([
            'product_id' => $product->id,
            'name' => 'منتج ١',
            'unit' => '١',
            'description' => 'محلاظة',
            'lang' => 'sa'
        ]);


    }
}
