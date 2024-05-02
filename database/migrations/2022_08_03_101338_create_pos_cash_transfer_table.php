<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCashTransferTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_cash_transfer', function (Blueprint $table) {
            $table->id();
            $table->foreignId('src_user_id')->constrained('temp_users');
            $table->foreignId('src_pos_id')->constrained('pos_cashiers');
            $table->foreignId('src_period_id')->constrained('pos_periods');
            $table->date('trans_date');
            $table->foreignId('dest_user_id')->constrained('temp_users');
            $table->foreignId('dest_pos_id')->constrained('pos_cashiers');
            $table->foreignId('dest_period_id')->constrained('pos_periods');
            $table->foreignId('currency_id')->constrained('c_currencies');
            $table->float('amount_value'); 
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
        Schema::dropIfExists('pos_cash_transfer');
    }
}
