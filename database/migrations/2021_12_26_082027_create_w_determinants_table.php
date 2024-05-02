<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWDeterminantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_determinants', function (Blueprint $table) {
            $table->id();

            $table->json('name')->nullable();

            $table->string("code")->nullable();
            $table->string("smallint")->nullable();
            $table->string("default_value")->nullable();
            $table->string("max_qty")->nullable();
            $table->boolean('is_unique')->default(0);
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
        Schema::dropIfExists('w_determinants');
    }
}
