<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWOffersDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_offers_detail', function (Blueprint $table) {
            $table->id();
            $table->smallInteger('kind');
            $table->float('required_qty');
            $table->float('offer_qrt');
            $table->float('max_offer_qty');
            $table->float('item_price');
            $table->float('discount_percent');
            $table->float('free_qty');

            $table->boolean('is_active')->default(1);
            $table->softDeletes();
            $table->timestamps();
            $table->foreignId('offer_id')->nullable()->constrained('w_offers')->onDelete('cascade');
            $table->foreignId('product_id')->nullable()->constrained('w_products')->onDelete('cascade');
            $table->foreignId('unit_id')->nullable()->constrained('w_units')->onDelete('cascade');
            $table->foreignId('warehouse_id')->nullable()->constrained('w_warehouses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w_offers_detail');
    }
}
