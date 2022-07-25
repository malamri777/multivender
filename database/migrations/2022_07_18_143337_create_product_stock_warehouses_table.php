<?php

use App\Models\ProductStock;
use App\Models\Warehouse;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_stock_warehouses', function (Blueprint $table) {
            $table->id();
            $table->double('price', 20, 2)->default(0);
            $table->integer('qty')->default(0);
            $table->foreignIdFor(ProductStock::class, 'product_stock_id')->constrained()->onDelete('cascade');
            $table->foreignIdFor(Warehouse::class, 'warehouse_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_stock_warehouses');
    }
};
