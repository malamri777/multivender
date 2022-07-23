
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->mediumText('slug');
            $table->string('sku')->unique();
            $table->string('name')->index('name');
            $table->string('added_by', 6)->default('admin');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('brand_id')->nullable();
            $table->string('photos', 2000)->nullable();
            $table->string('thumbnail_img', 100)->nullable();
            $table->string('tags', 500)->nullable()->index('tags');
            $table->longText('description')->nullable();
            $table->integer('variant_product')->default(0);
            $table->double('purchase_price', 20, 2)->nullable();
            $table->string('attributes', 1000)->default('[]');
            $table->mediumText('choice_options')->nullable();
            $table->mediumText('colors')->nullable();
            $table->text('variations')->nullable();
            $table->integer('published')->default(1);
            $table->boolean('approved')->default(true);
            $table->integer('todays_deal')->default(0);
            $table->boolean('cash_on_delivery')->default(false)->comment('1 = On, 0 = Off');
            $table->integer('featured')->default(0);
            $table->integer('seller_featured')->default(0);
            $table->string('unit', 20)->nullable();
            $table->integer('min_qty')->default(1);
            $table->boolean('is_quantity_multiplied')->default(false)->comment('1 = Mutiplied with shipping cost');
            $table->integer('est_shipping_days')->nullable();
            $table->integer('num_of_sale')->default(0);
            $table->mediumText('meta_title')->nullable();
            $table->longText('meta_description')->nullable();
            $table->string('meta_img', 255)->nullable();
             $table->integer('low_stock_quantity')->nullable();

            //  $table->double('unit_price', 20, 2)->index('unit_price')->default(0);
            //  $table->string('stock_visibility_state', 10)->default('quantity');
            //  $table->double('discount', 20, 2)->nullable();
            //  $table->string('discount_type', 10)->nullable();
            //  $table->integer('discount_start_date')->nullable();
            //  $table->integer('discount_end_date')->nullable();
            // $table->integer('current_stock')->default(0);
            // $table->string('shipping_type', 20)->nullable()->default('flat_rate');
            // $table->double('shipping_cost', 20, 2)->default(0);

            $table->timestamp('created_at')->useCurrent()->index('created_at');
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
