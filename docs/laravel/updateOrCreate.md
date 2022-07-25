
```php

 public function store_exist(WarehouseProductReqeust $request)
    {

        $result = WarehouseProduct::updateOrCreate([
            'id' => $request->warehouse_product_id,
        ],[
            "name" => $request->name,
            "warehouse_id" => $request->warehouse_id,
            "price" => $request->price,
            "sale_price" => $request->sale_price,
            "quantity" => $request->quantity,
            "product_id" => $request->product_id,
            "warehouse_product_id" => $request->warehouse_product_id,
            'updated_by_id' =>  Auth::user()->id,
            'created_by_id' =>  Auth::user()->id,
        ]);

        if(!$result->wasRecentlyCreated && $result->wasChanged()){
            // updateOrCreate performed an update
            dd('updateOrCreate performed an update');
        }

        if(!$result->wasRecentlyCreated && !$result->wasChanged()){
            // updateOrCreate performed nothing, row did not change
            dd('updateOrCreate performed nothing, row did not change');
        }

        if($result->wasRecentlyCreated){
           // updateOrCreate performed create
           dd('updateOrCreate performed create');
        }

        dd('none');
        flash(translate('Warehouse Product Updated'))->success();
        flash(translate('Warehouse Product Created'))->success();
        return redirect()->route('supplier.products');
    }

```
