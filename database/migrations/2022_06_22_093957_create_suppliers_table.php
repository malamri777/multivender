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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('cr_no')->unique();
            $table->string('vat_no')->unique();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('contact_user')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('logo')->default('assets/img/logo.png');
            $table->tinyInteger('status')->default(0);
            $table->tinyInteger('supplier_waiting_for_upload_file')->default(0);
            $table->tinyInteger('supplier_waiting_for_admin_approve')->default(0);
            $table->integer('order')->default(0);

            $table->foreignIdFor(\App\Models\User::class, 'admin_id' )->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
