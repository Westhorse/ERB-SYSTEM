<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWPriceListDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_price_list_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('priceList_id')->nullable()->constrained('w_price_lists');
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('unit_id')->nullable()->constrained('w_units');
            $table->unique(["product_id", "unit_id", "priceList_id"], 'unique');
            $table->float('price')->nullable();
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
        Schema::dropIfExists('w_price_list_details');
    }
}
