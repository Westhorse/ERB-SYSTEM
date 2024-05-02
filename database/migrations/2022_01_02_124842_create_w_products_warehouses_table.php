<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductsWarehousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_products_warehouses', function (Blueprint $table) {
            $table->id();
            $table->string('item_location')->nullable();
            $table->float('min_level')->nullable();
            $table->float('max_level')->nullable();
            $table->float('reload_level')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('warehouse_id')->nullable()->constrained('w_warehouses');
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('w_products_warehouses');
    }
}
