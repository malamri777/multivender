<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDistrictWarehouseDriverPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // district_warehouse_driver => change to district_wh_driver
        Schema::create('district_wh_driver', function (Blueprint $table) {
            $table->unsignedBigInteger('district_id')->index();
            $table->foreign('district_id')->references('id')->on('districts')->onDelete('cascade');
            $table->integer('wh_driver_id')->nullable();

//             $table->unsignedBigInteger('wh_driver_id')->index();
//             $table->foreign('wh_driver_id')->references('¡id')->on('warehouse_driver')->onDelete('cascade');
//             $table->primary(['district_id', 'wh_driver_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('district_wh_driver');
    }
}
