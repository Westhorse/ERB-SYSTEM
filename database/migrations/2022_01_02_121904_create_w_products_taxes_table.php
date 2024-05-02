<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductsTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_products_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('tax_id')->nullable()->constrained('c_taxes');
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
        Schema::dropIfExists('w_products_taxes');
    }
}
