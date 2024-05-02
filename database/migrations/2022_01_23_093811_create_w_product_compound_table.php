<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductCompoundTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_product_compound', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('src_product_id')->nullable()->constrained('w_products');
            $table->string("product_qty")->nullable();
            $table->string("cost_price")->nullable();
            $table->string("sell_price")->nullable();
            $table->timestamps();
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('w_product_compound');
    }
}
