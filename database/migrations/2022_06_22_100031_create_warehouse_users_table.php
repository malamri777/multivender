
<?php

use App\Models\User;
use App\Models\Warehouse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWarehouseUsersTable extends Migration
{
    public function up()
    {
        Schema::create('warehouse_users', function (Blueprint $table) {
            $table->foreignIdFor(User::class, 'user_id');
            // ->constrained()->onDelete('cascade');
            $table->foreignIdFor(Warehouse::class, 'warehouse_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('warehouse_users');
    }
}
