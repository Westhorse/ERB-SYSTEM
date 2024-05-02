<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillsItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bills_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('c_bills');
            $table->foreignId('warehouse_id')->constrained('w_warehouses');
            $table->foreignId('product_id')->constrained('w_products');
            $table->foreignId('unit_id')->constrained('w_units');
            $table->json('item_desc')->nullable();
            $table->float('add_qty')->default(0.0);
            $table->float('converted_add_qty')->default(0.0);
            $table->float('issue_qty')->default(0.0);
            $table->float('converted_issue_qty')->default(0.0);
            $table->float('unit_price')->default(0.0);
            $table->float('total_price')->default(0.0);
            $table->float('total_price_with_tax')->default(0.0);
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
        Schema::dropIfExists('c_bills_items');
    }
}
