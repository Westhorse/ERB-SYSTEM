<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('c_bills');
            $table->enum('installment_way', [0, 1, 2]);
            $table->smallInteger('period_start')->default(1);
            $table->boolean('calc_by_hijri')->default(true);
            $table->float('first_payment')->nullable();
            $table->date('first_payment_date')->nullable();
            $table->date('start_date')->nullable();
            $table->float('installment_value')->default(0);
            $table->integer('installment_count')->default(0);
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
        Schema::dropIfExists('c_bill_installments');
    }
}
