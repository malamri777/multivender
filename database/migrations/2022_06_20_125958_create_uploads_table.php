<?php

use App\Models\Restaurant;
use App\Models\Supplier;
use App\Models\Upload;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploads', function (Blueprint $table) {
            $table->id();
            $table->string('folder_name')->nullable();
            $table->string('folder_name_slug')->nullable();
//            $table->string('folder_id')->default(0);
            $table->integer('order')->default(1);
            $table->foreignIdFor(Upload::class, 'folder_id')->nullable();
            $table->string('file_original_name', 255)->nullable();
            $table->string('file_name', 255)->nullable();
            $table->integer('user_id')->nullable();
            $table->integer('file_size')->nullable();
            $table->string('extension', 10)->nullable();
            $table->string('type', 15)->nullable();
            $table->string('external_link', 500)->nullable();
            $table->string('role_type')->default(Upload::ROLE_TYPE['admin'])->comment('enum class in type');
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
        Schema::dropIfExists('uploads');
    }
}
