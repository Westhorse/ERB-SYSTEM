<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCPaymentTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_payment_types', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();

            $table->string('code')->nullable();
            $table->boolean('fees_type')->default(1);
            $table->integer('fees_value')->nullable();
            $table->double('max_fees_value', 10, 2)->nullable();
            $table->double('tax_percent', 10, 2)->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('temp_account_id')->nullable()->constrained();
            $table->foreignId('fees_account_id')->nullable()->constrained('temp_accounts')->nullable();
            $table->foreignId('tax_account_id')->nullable()->constrained('temp_accounts')->nullable();
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
        Schema::dropIfExists('c_payment_types');
    }
}
