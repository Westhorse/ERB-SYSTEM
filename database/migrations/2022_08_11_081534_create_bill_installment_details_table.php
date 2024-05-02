<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBillInstallmentDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_installment_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_installment_id')->constrained('c_bill_installments');
            $table->date('installment_date')->nullable();
            $table->float('installment_value')->nullable();
            $table->boolean('installment_status')->default(false);
            $table->json('remarks');
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
        Schema::dropIfExists('c_bill_installment_details');
    }
}
