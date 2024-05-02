<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCDocumentIssuerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_document_issuer', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('code')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('branch_id')->nullable()->constrained('c_branches')->onDelete('cascade');
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
        Schema::dropIfExists('c_document_issuer');
    }
}
