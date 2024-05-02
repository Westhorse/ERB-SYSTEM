<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWDocumentryCreditExpensesTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_documentry_credit_expenses_type', function (Blueprint $table) {
            $table->id();
            $table->json('name')->nullable();
            $table->string('code')->nullable();
            $table->smallInteger('cost_effect')->nullable();
            $table->smallInteger('cost_distribution')->nullable();
            $table->smallInteger('generate_entry')->nullable();
            $table->float('tax_percent')->nullable();
            $table->boolean('auto_entry_posting')->default(1);
            $table->boolean('match_voucher_value')->default(0);
            $table->boolean('repeate_voucher')->default(0);
            $table->boolean('code_by_user')->default(0);
            $table->boolean('taxable')->default(0);
            $table->foreignId('default_account_Id')->nullable()->constrained('temp_accounts');
            $table->foreignId('tax_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('opposite_account_id')->nullable()->constrained('temp_accounts');
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
        Schema::dropIfExists('w_documentry_credit_expenses_type');
    }
}
