<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStockWarehouse extends Model
{
    use HasFactory;

    protected $fillable = ['qty', 'price', 'product_stock_id', 'warehouse_id'];

    public function productStock()
    {
        return $this->belongsTo(ProductStock::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
