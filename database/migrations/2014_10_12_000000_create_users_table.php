<?php

use App\Models\Restaurant;
use App\Models\Supplier;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->integer('referred_by')->nullable();
            $table->string('user_type', 50)->default('customer');
            $table->string('name');
            $table->string('email')->unique()->index();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('country_dail_code')->default("966");
            $table->string('country_code')->default("sa");
            $table->string('otp_code')->nullable();
            $table->string('otp_code_count')->default(0);
            $table->string('otp_code_time_amount_left')->nullable();
            $table->string('new_email_verificiation_code')->nullable();
            $table->string('password')->nullable();
            $table->string('device_token', 255)->nullable();
            $table->string('avatar', 256)->nullable();
            $table->string('avatar_original', 256)->nullable();
            $table->string('address', 300)->nullable();
            $table->string('country', 30)->nullable();
            $table->string('state', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->double('balance', 20, 2)->default(0);
            $table->tinyInteger('banned')->default(0);
            $table->string('referral_code', 255)->nullable();
            $table->integer('customer_package_id')->nullable();
            $table->integer('remaining_uploads')->nullable()->default(0);

            $table->foreignIdFor(Supplier::class, 'provider_id')->nullable();
            $table->foreignIdFor(Restaurant::class, 'restaurant_id')->nullable();
            $table->timestamps();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
