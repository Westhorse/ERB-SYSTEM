<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCTaxesDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_taxes_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('amount_type')->default(1);
            $table->float('amount_value')->nullable();
            $table->integer('impact')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->bigInteger('sales_tax_account_id')->nullable();
            $table->bigInteger('purchase_tax_account_id')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('c_countries');
            $table->foreignId('tax_id')->nullable()->constrained('c_taxes');
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('c_taxes_detail');
    }
}
