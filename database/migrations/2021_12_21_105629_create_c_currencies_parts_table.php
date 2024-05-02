<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCCurrenciesPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_currencies_parts', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->float('rate')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('currency_id')->nullable()->constrained('c_currencies');
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
        Schema::dropIfExists('c_currencies_parts');
    }
}
