<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseWarehouseUserPivotTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse_warehouse_user', function (Blueprint $table) {
            $table->unsignedBigInteger('warehouse_user_id');
            $table->foreign('warehouse_user_id', 'warehouse_user_id_fk_6815003')->references('id')->on('warehouse_users')->onDelete('cascade');
            $table->unsignedBigInteger('warehouse_id');
            $table->foreign('warehouse_id', 'warehouse_id_fk_6815003')->references('id')->on('warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_warehouse_user');
    }
}
