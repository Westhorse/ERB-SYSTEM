<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillEffectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_effects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_id')->constrained('c_bills');
            $table->tinyInteger('effect_type');
            $table->tinyInteger('effect_amount_type');
            $table->float('effect_amount');
            $table->float('effect_value')->default(0.0);
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');
            $table->json('remarks')->nullable();
            $table->foreignId('opposite_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('currency_id')->nullable()->constrained('c_currencies');
            $table->float('conversion_factor')->nullable();
            $table->string('reference',255)->nullable();
            $table->string('reference_no',100)->nullable();
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
        Schema::dropIfExists('c_bill_effects');
    }
}
