<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePosCashTransferDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pos_cash_transfer_detail', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transfer_id')->constrained('pos_cash_transfer');
            $table->foreignId('part_id')->constrained('c_currencies_parts');
            $table->integer('part_count');
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
        Schema::dropIfExists('pos_cash_transfer_detail');
    }
}
