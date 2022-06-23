<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseWarehouseDriverPivotTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse_warehouse_driver', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_driver_id');
            $table->foreign('warehouse_driver_id', 'warehouse_driver_id_fk_6815015')->references('id')->on('warehouse_drivers')->onDelete('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id', 'warehouse_id_fk_6815015')->references('id')->on('warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_warehouse_driver');
    }
}
