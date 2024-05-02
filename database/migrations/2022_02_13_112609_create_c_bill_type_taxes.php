<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillTypeTaxes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_type_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('tax_id')->nullable()->constrained('c_taxes');
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
        Schema::dropIfExists('c_bill_type_taxes');
    }
}
