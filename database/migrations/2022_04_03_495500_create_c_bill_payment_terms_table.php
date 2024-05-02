<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillPaymentTermsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_payment_terms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('c_bills');
            $table->float('payment_amount')->nullable();
            $table->float('payment_percent')->nullable();
            $table->date('payment_date')->nullable();
            $table->json('remarks')->nullable();
            $table->json('notes')->nullable();
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
        Schema::dropIfExists('c_bill_payment_terms');
    }
}
