<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('w_product_categories')) {

            Schema::create('w_product_categories', function (Blueprint $table) {
                $table->id();
                $table->string("code")->nullable();
                $table->json('name');
                $table->json('notes')->nullable();
                $table->boolean('is_active')->default(1);
                $table->smallInteger('cost_way')->default(1);
                $table->smallInteger('apply_tax')->default(0);
                $table->smallInteger('product_type')->default(0);
                $table->float('cash_commission')->nullable();
                $table->float('later_commission')->nullable();
                $table->smallInteger('commission_type')->default(0);
                $table->smallInteger('purchase_disc_type')->default(0);
                $table->smallInteger('purchase_disc_amount_type')->default(1);
                $table->float('purchase_disc_amount')->default(0);
                $table->smallInteger('cost_price_effect')->default(0);
                $table->float('buy_free_percent')->default(0);
                $table->smallInteger('sale_disc_type')->default(0);
                $table->smallInteger('sale_disc_amount_type')->default(1);
                $table->float('sale_disc_amount')->default(0);
                $table->float('sale_free_percent')->default(0);

                $table->foreignId('parent_id')->nullable()->constrained('w_product_categories')->restrictOnDelete();
                $table->foreignId('branch_id')->nullable()->constrained('c_branches')->restrictOnDelete();
                $table->foreignId('unit_id')->nullable()->constrained('w_units')->restrictOnDelete();
                $table->foreignId('sales_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();
                $table->foreignId('resales_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();
                $table->foreignId('purchase_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();
                $table->foreignId('repurchase_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();
                $table->foreignId('cost_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();
                $table->foreignId('stock_account_id')->nullable()->constrained('temp_accounts')->restrictOnDelete();

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
        Schema::dropIfExists('w_product_categories');
    }
}
