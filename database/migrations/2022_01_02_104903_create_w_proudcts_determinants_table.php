<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProudctsDeterminantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_proudcts_determinants', function (Blueprint $table) {
            $table->id();
            $table->integer('in_product_balanct')->default(0);
            $table->integer('in_product_qty')->default(0);
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('determinant_id')->nullable()->constrained('w_determinants');
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
        Schema::dropIfExists('w_proudcts_determinants');
    }
}
