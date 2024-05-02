<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWTransferItemsVouchersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_transfer_items_vouchers', function (Blueprint $table) {
            $table->id();
            $table->date('voucher_date')->nullable();
            $table->foreignId('ref_bill_type_id')->constrained('c_bill_types');
            $table->foreignId('ref_bill_id')->constrained('c_bills');
            $table->foreignId('src_warehouse_id')->constrained('w_warehouses');
            $table->foreignId('dest_warehouse_id')->constrained('w_warehouses');
            $table->foreignId('currency_id')->constrained('c_currencies');
            $table->float('conversion_rate');
            $table->foreignId('src_branch_id')->constrained('c_branches');
            $table->foreignId('dest_branch_id')->constrained('c_branches');
            $table->foreignId('in_bill_type_id')->constrained('c_bill_types');
            $table->foreignId('out_bill_type_id')->constrained('c_bill_types');
            $table->json('remarks');
            //TODO:temps
            $table->foreignId('deliverer_id')->constrained('temp_employees');
            $table->foreignId('receiver_id')->constrained('temp_employees');
            $table->foreignId('input_cost_center_id')->constrained('temp_cost_centers');
            $table->foreignId('output_cost_center_id')->constrained('temp_cost_centers');
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
        Schema::dropIfExists('w_transfer_items_vouchers');
    }
}
