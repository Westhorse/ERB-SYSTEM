<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillItemTaxesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_items_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_item_id')->constrained('c_bills_items')->onDelete('cascade');
            $table->foreignId('tax_id')->constrained('c_taxes');
            $table->float('tax_percent')->nullable();
            $table->float('tax_value')->nullable();
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
        Schema::dropIfExists('c_bill_items_taxes');
    }
}
