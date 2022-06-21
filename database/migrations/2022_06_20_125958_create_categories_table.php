<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable()->default(0);
            $table->integer('level')->default(0);
            $table->string('name', 50);
            $table->integer('order_level')->default(0);
            $table->double('commision_rate', 8, 2)->default(0);
            $table->string('banner', 100)->default('/assets/img/banner-placeholder.png');
            $table->string('icon', 100)->default('/assets/img/icon-placeholder.jpeg');
            $table->integer('featured')->default(0);
            $table->integer('top')->default(0);
            $table->integer('digital')->default(0);
            $table->string('slug', 255)->nullable()->index('slug');
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
