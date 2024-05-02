<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCDocumentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_document_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name')->nullable();
            $table->integer('dtype')->nullable();
            $table->boolean('follow_renewal')->nullable();
            $table->integer('days_count')->nullable();
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
        Schema::dropIfExists('c_document_types');
    }
}
