<?php

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
        Schema::create('branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->decimal('long', 10, 7)->nullable();
            $table->decimal('lat', 10, 7)->nullable();

            $table->foreignIdFor(\App\Models\User::class, 'admin_id' )->nullable();
            $table->foreignIdFor(\App\Models\Restaurant::class, 'restaurant_id' );
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('branches');
    }
};
