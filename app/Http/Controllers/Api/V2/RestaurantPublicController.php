<?php

namespace App\Http\Controllers\Api\V2;

use App\Http\Resources\V2\ProductCollection;
use App\Http\Resources\V2\SupplierCollection;
use App\Models\Product;
use App\Models\Supplier;
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
}
