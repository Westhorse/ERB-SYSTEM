<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWDeterminantsDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_determinants_detail', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->boolean('is_default')->default(0);
            $table->foreignId('determinant_id')->nullable()->constrained('w_determinants');
            $table->softDeletes();
            $table->boolean('is_active')->default(1);
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
        Schema::dropIfExists('w_determinants_detail');
    }
}
