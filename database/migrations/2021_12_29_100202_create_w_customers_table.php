<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_customers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name')->nullable();
            $table->string('telephone')->nullable();
            $table->string('fax_number')->nullable();
            $table->string('tax_number')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('price_list_id')->nullable();
            $table->foreignId('branch_id')->nullable();
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
        Schema::dropIfExists('w_customers');
    }
}