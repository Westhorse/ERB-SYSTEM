<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateCLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_languages', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name');
            $table->string('key');
            $table->boolean('is_active')->default(1);
            $table->boolean('rtl')->default(1);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('c_languages');
    }
}
