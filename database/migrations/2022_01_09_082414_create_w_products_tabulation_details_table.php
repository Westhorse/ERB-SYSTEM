<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductsTabulationDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_products_tabulation_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('productTabulation_id')->nullable()->constrained('w_products_tabulation');
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('w_products_tabulation_details');
    }
}
