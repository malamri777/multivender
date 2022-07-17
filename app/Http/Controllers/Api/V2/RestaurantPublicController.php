<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\CategoryCollection;
use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\ProductMiniCollection;
use App\Http\Resources\V2\ProductResource;
use App\Http\Resources\V2\SupplierCollection;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use Cache;
use Illuminate\Http\Request;

class RestaurantPublicController extends Controller
{
    public function supplierList() {
        $suppliers = Supplier::where('supplier_waiting_for_upload_file', 1)
            ->where('supplier_waiting_for_admin_approve', 1)
            ->orderBy('order')->paginate(10);
        $supplierResource = new SupplierCollection($suppliers);
        return $supplierResource;
    }

    public function productBySupplier(Supplier $supplier) {
        $products = Product::whereHas('warehouse', function ($q) use ($supplier){
            $q->where('supplier_id', $supplier->id);
        })->paginate(10);
        $productCollection = new ProductCollection($products);
        return $productCollection;
    }

    public function related($id)
    {
        return Cache::remember("app.related_products-$id", 86400, function () use ($id) {
            $product = Product::find($id);
            $products = Product::where('category_id', $product->category_id)->where('id', '!=', $id)->physical();
            return new ProductMiniCollection(filter_products($products)->limit(10)->get());
        });
    }

    public function show($id)
    {
        return Cache::remember("app.product-show-$id", 86400, function () use ($id) {
            $product = Product::find($id);
            $productResource = new ProductResource($product);
            return $productResource;
        });
    }

    public function categoryList() {
        return Cache::remember("app.product-category", 86400, function () use ($id) {
            $categories = Category::get();
            return CategoryCollection::make($categories);
        });
    }
}
