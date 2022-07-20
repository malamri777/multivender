<?php

use App\Models\Warehouse;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseProductsTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('price', 15, 2);
            $table->decimal('sale_price', 15, 2)->nullable();
            $table->integer('quantity')->nullable();

            $table->string('sale_price_type', 10)->nullable();
            $table->string('sale_price_start_date')->nullable();
            $table->string('sale_price_end_date')->nullable();
            $table->integer('low_stock_quantity')->nullable();

            $table->foreignIdFor(Warehouse::class, 'warehouse_id');
            $table->foreignIdFor(Product::class, 'product_id');
            $table->foreignIdFor(User::class, 'create_by_id')->nullable();
            $table->foreignIdFor(User::class, 'updated_by_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_products');
    }
}
