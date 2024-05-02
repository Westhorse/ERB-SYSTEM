<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWDocumentaryCreditTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_documentary_credit_types', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name');

            $table->tinyInteger('shipping_type')->default(1);
            $table->foreignId('shipping_policy_id')->nullable()->constrained('w_shipping_policy')->restrictOnDelete();

            $table->foreignId('credit_ref_bill_type_id')->constrained('c_bill_types')->restrictOnDelete();
            $table->foreignId('shipping_bill_type_id')->constrained('c_bill_types')->restrictOnDelete();
            $table->foreignId('receive_bill_type_id')->constrained('c_bill_types')->restrictOnDelete();

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
        Schema::dropIfExists('w_documentary_credit_types');
    }
}
