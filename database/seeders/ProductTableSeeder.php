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

        /*
4	Octavia Compton	admin	2	4	1	2	2	dailymotion	Expedita consequuntu		<p>Vivamus elementum semper nisi. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Nulla consequat massa quis enim. Cras risus ipsum, faucibus ut, ullamcorper id, varius ac, leo.</p><p><br></p><p>Nam ipsum risus, rutrum vitae, vestibulum eu, molestie vel, lacus. Vivamus quis mi. Nunc interdum lacus sit amet orci. Aliquam erat volutpat.</p><p><br></p><p>Vivamus laoreet. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Curabitur vestibulum aliquam leo.</p><p><br></p><p>Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Maecenas egestas arcu quis ligula mattis placerat. Pellentesque ut neque. Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui.</p>	80.0	0.0	0	["1"]	[{"attribute_id":"1","values":["Small"]}]	[]		0	1	1	quantity	1	0	0	78	Sunt minim eiusmod e	640	129	44.0	amount	1655942400	1656201540			free	0.0	0	24	0	Nulla et vero et con	Omnis a omnis neque	2		octavia-compton-3	0.0		0	0			Veritatis velit qui	Nulla est ipsum sed	0	2022-06-23 08:22:47	2022-06-23 08:22:47
        */

        // // Product
        // $product = Product::create([
        //     'name' => 'Product One',
        //     'added_by' => 'admin',
        //     'user_id' => 1,
        //     'category_id' => 1,
        //     'brand_id' => 1,
        //     'sku' => 'sku1',
        //     'photos' => 5,
        //     'thumbnail_img' => 5,
        //     'tags' => 'product',
        //     'description' => '<p>Vivamus elementum semper nisi. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Nulla consequat massa quis enim. Cras risus ipsum, faucibus ut, ullamcorper id, varius ac, leo.</p><p><br></p><p>Nam ipsum risus, rutrum vitae, vestibulum eu, molestie vel, lacus. Vivamus quis mi. Nunc interdum lacus sit amet orci. Aliquam erat volutpat.</p><p><br></p><p>Vivamus laoreet. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Curabitur vestibulum aliquam leo.</p><p><br></p><p>Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Maecenas egestas arcu quis ligula mattis placerat. Pellentesque ut neque. Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui.</p>',
        //     // 'unit_price' => 500,
        //     'purchase_price' => 250,
        //     'choice_options' => '[{"attribute_id":"1","values":["Small"]}]',
        //     'colors' => '[]',
        //     'cash_on_delivery' => true,
        //     'unit' => 1
        // ]);

        // Product::create([
        //     'name' => 'Product Two',
        //     'added_by' => 'admin',
        //     'user_id' => 1,
        //     'category_id' => 1,
        //     'brand_id' => 1,
        //     'sku' => 'sku2',
        //     'photos' => 5,
        //     'thumbnail_img' => 5,
        //     'tags' => 'product',
        //     'description' => '<p>Vivamus elementum semper nisi. Maecenas ullamcorper, dui et placerat feugiat, eros pede varius nisi, condimentum viverra felis nunc et lorem. Nulla consequat massa quis enim. Cras risus ipsum, faucibus ut, ullamcorper id, varius ac, leo.</p><p><br></p><p>Nam ipsum risus, rutrum vitae, vestibulum eu, molestie vel, lacus. Vivamus quis mi. Nunc interdum lacus sit amet orci. Aliquam erat volutpat.</p><p><br></p><p>Vivamus laoreet. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Integer ante arcu, accumsan a, consectetuer eget, posuere ut, mauris. Curabitur vestibulum aliquam leo.</p><p><br></p><p>Donec mi odio, faucibus at, scelerisque quis, convallis in, nisi. Maecenas egestas arcu quis ligula mattis placerat. Pellentesque ut neque. Sed augue ipsum, egestas nec, vestibulum et, malesuada adipiscing, dui.</p>',
        //     // 'unit_price' => 500,
        //     'purchase_price' => 250,
        //     'choice_options' => '[{"attribute_id":"1","values":["Small"]}]',
        //     'colors' => '[]',
        //     'cash_on_delivery' => true,
        //     'unit' => 1
        // ]);

        // ProductTranslation::create([
        //     'product_id' => $product->id,
        //     'name' => 'منتج ١',
        //     'unit' => '١',
        //     'description' => 'محلاظة',
        //     'lang' => 'sa'
        // ]);

        $path = base_path() . '/database/seeders/data/Product.json';
        $products = json_decode(file_get_contents($path), true);
        foreach ($products['products'] as $product) {
            Product::create($product);
        }

    }
}
