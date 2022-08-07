<?php

$json_data = json_decode(file_get_contents(storage_path() . "/app/list.json"), true);
$data = $json_data["Orient Provision"];

foreach ($data as $item) {

    $brandId = Brand::where('name', $item["BRAND"])->first()?->id;
    if (!$brandId) {
        $brand = Brand::create(['name' => $item["BRAND"]]);
        $brandId = $brand->id;
    }

    $product = Product::where('sku', '=',  $item["ITMCODE"])->first();

    if (!isset($product)) {
        $newProduct = Product::create([
            'sku' => $item['ITMCODE'],
            'name' => $item['ITEM NAME ENGLISH'],
            'brand_id' => $brandId,
            'user_id' => 1,
            'category_id' => 1

        ]);

        $newProducteTranslations = ProductTranslation::create([
            'product_id' => $newProduct->id,
            'name' => $item["ITEM NAME ARABIC"],
            'lang' => 'ar'
        ]);
    }
}

echo "Done <br />";
