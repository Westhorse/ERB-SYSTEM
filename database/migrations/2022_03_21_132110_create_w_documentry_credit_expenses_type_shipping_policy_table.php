<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWDocumentryCreditExpensesTypeShippingPolicyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('w_documentry_credit_expenses_type_shipping_policy')) {
            Schema::create('w_documentry_credit_expenses_type_shipping_policy', function (Blueprint $table) {
                $table->id();
                $table->integer('documentry_id')->nullable()->constrained('w_documentry_credit_expenses_type');
                $table->integer('shipping_id')->nullable()->constrained('w_shipping_policy');
                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('w_documentry_credit_expenses_type_shipping_policy');
    }
}
