<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration
{
    public function up()
    {
        Schema::create('warehouses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(1);

            $table->foreignIdFor(\App\Models\User::class, 'admin_id' )->nullable();
            $table->foreignIdFor(\App\Models\Supplier::class, 'supplier_id' );
            $table->foreignIdFor(\App\Models\Country::class, 'country_id' );
            $table->foreignIdFor(\App\Models\State::class, 'state_id' );
            $table->foreignIdFor(\App\Models\City::class, 'city_id' );
            $table->foreignIdFor(\App\Models\District::class, 'district_id' );

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouses');
    }
}
