<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehouseDriversTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse_drivers', function (Blueprint $table) {
            $table->id();
            $table->string('blood_group')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->string('vehicle_registration_no')->nullable();
            $table->longText('vehicle_details')->nullable();
            $table->string('driving_license_no')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id', 'user_fk_6815016')->references('id')->on('users');
            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->foreign('nationality_id', 'nationality_fk_6815017')->references('id')->on('countries');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_drivers');
    }
}
