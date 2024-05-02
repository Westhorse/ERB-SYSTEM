<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCCurrenciesExchangeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_currencies_exchange', function (Blueprint $table) {
            $table->id();
            $table->float('exchange_rate')->nullable();
            $table->string('exchange_date')->nullable();
            $table->foreignId('from_currency_id')->nullable()->constrained('c_currencies');
            $table->foreignId('to_currency_id')->nullable()->constrained('c_currencies');
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
        Schema::dropIfExists('c_currencies_exchange');
    }
}
