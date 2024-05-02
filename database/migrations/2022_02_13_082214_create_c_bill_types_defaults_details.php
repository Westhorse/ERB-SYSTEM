<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillTypesDefaultsDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_types_defaults_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_type_default_id')->nullable()->constrained('c_bill_types_defaults');
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('opposite_account_id')->nullable()->constrained('temp_accounts');
            $table->tinyInteger('payment_type')->nullable();
            $table->json('label')->nullable();
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
        Schema::dropIfExists('c_bill_types_defaults_details');
    }
}
