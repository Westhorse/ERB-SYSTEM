<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCVehicleDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_vehicle_documents', function (Blueprint $table) {
            $table->id();
            $table->string('doc_serial')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('notes')->nullable();
            $table->double('value')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('vehicle_data_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('document_type_id')->nullable()->constrained('c_document_types');
            $table->foreignId('document_issuer_id')->nullable()->constrained('c_document_issuer');
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
        Schema::dropIfExists('c_vehicle_documents');
    }
}
