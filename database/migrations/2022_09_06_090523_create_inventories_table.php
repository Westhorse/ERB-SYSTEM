<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_inventories', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->json('name');
            $table->date('inventory_date');
            $table->foreignId('warehouse_id')->constrained('w_warehouses');
            $table->foreignId('currency_id')->constrained('c_currencies');
            $table->float('conversion_factor');
            $table->json('remarks')->nullable();
            $table->tinyInteger('inventory_type')->default(1);
            $table->boolean('is_approved')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('inventories');
    }
};
