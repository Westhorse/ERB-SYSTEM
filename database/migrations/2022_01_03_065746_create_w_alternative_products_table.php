<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWAlternativeProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_alternative_products', function (Blueprint $table) {
            $table->id();
            $table->integer('alternative_type')->default(1);
            $table->foreignId('main_product_id')->nullable()->constrained('w_products');
            $table->foreignId('alternate_product_id')->nullable()->constrained('w_products');
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
        Schema::dropIfExists('w_alternative_products');
    }
}
