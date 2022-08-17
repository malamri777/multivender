<?php

use App\Models\Upload;
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
            $table->string('slug');
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

            $table->longText('sliders')->nullable();
            $table->integer('num_of_reviews')->default(0);
            $table->integer('num_of_sale')->default(0);
            $table->integer('seller_package_id')->nullable();
            $table->integer('product_upload_limit')->default(0);
            $table->date('package_invalid_at')->nullable();
            $table->integer('verification_status')->default(0);
            $table->longText('verification_info')->nullable();
            $table->integer('cash_on_delivery_status')->default(0);
            $table->double('admin_to_pay', 20, 2)->default(0);
            $table->string('facebook', 255)->nullable();
            $table->string('instagram', 255)->nullable();
            $table->string('google', 255)->nullable();
            $table->string('twitter', 255)->nullable();
            $table->string('youtube', 255)->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->text('pick_up_point_id')->nullable();
            $table->double('shipping_cost', 20, 2)->default(0);
            $table->float('delivery_pickup_latitude', 10, 0)->nullable();
            $table->float('delivery_pickup_longitude', 10, 0)->nullable();
            $table->string('bank_name', 255)->nullable();
            $table->string('bank_acc_name', 200)->nullable();
            $table->string('bank_acc_no', 50)->nullable();
            $table->integer('bank_routing_no')->nullable();
            $table->integer('bank_payment_status')->default(0);

            $table->foreignIdFor(\App\Models\Upload::class, 'parent_folder_id' )->nullable();
            $table->foreignIdFor(Upload::class, 'cr_file')->nullable();
            $table->foreignIdFor(Upload::class, 'vat_file')->nullable();
            $table->json('wathqData')->nullable();
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
