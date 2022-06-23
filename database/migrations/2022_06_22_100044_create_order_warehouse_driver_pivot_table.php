<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderWarehouseDriverPivotTable extends Migration
{
    public function up()
    {
        Schema::create('order_warehouse_driver', function (Blueprint $table) {
            $table->unsignedBigInteger('order_id');
            $table->foreign('order_id', 'order_id_fk_6815022')->references('id')->on('orders')->onDelete('cascade');
            $table->unsignedBigInteger('warehouse_driver_id');
            $table->foreign('warehouse_driver_id', 'warehouse_driver_id_fk_6815022')->references('id')->on('warehouse_drivers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('order_warehouse_driver');
    }
}
