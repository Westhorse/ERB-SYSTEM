<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductsUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_products_units', function (Blueprint $table) {
            $table->id();
            $table->float('convert_rate')->nullable();
            $table->float('sales_price')->nullable();
            $table->float('min_sales_price')->nullable();
            $table->float('barcode')->nullable();
            $table->float('weight')->nullable();
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('unit_id')->nullable()->constrained('w_units');
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
        Schema::dropIfExists('w_products_units');
    }
}
