<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('w_products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->json('name')->nullable();
            $table->integer('product_type')->default(0);
            $table->string('barcode')->nullable();
            $table->boolean('is_active')->default(1)->nullable();
            $table->string('color')->nullable();
            $table->string('model')->nullable();
            $table->string('Producer')->nullable();
            $table->integer('cost_way')->default(1);
            $table->float('cash_commission')->nullable();
            $table->float('later_commission')->nullable();
            $table->integer('commission_type')->default(0);
            $table->float('max_stock')->nullable();
            $table->float('min_stock')->nullable();
            $table->float('order_limit')->nullable();
            $table->json('description')->nullable();
            $table->float('default_qty')->nullable();
            $table->float('initial_cost_price')->nullable();
            $table->float('cost_price')->nullable();
            $table->float('sales_price')->nullable();
            $table->float('min_sales_price')->nullable();
            $table->float('weight')->nullable();
            $table->float('transportation_fees')->nullable();
            $table->integer('purchase_disc_type')->default(0);
            $table->integer('purchase_disc_amount_type')->default(1);
            $table->float('purchase_disc_amount')->default(0);
            $table->float('cost_price_effect')->default(0);
            $table->float('buy_free_percent')->default(0);
            $table->float('max_purchase_disc_amount')->default(0);
            $table->integer('sale_disc_type')->default(0);
            $table->integer('sale_disc_amount_type')->default(0);
            $table->float('sale_disc_amount')->default(0);
            $table->float('sale_free_percent')->default(0);
            $table->float('max_sales_disc_amount')->default(0);
            $table->float('life_time')->default(0);
            $table->integer('life_time_type')->default(0);
            $table->float('is_diff_weight_mat')->default(0);
            $table->float('has_nofraction')->default(0);
            $table->integer('guarantee_days')->nullable();
            $table->integer('product_kind')->default(0);
            $table->float('lengh_factor')->nullable();
            $table->float('width_factor')->nullable();
            $table->float('height_factor')->nullable();
            $table->integer('scales_material')->default(0);
            $table->integer('scales_part1')->nullable();
            $table->integer('scales_part2')->nullable();
            $table->integer('scales_part3')->nullable();
            $table->integer('taxable')->default(0);
            $table->integer('apply_tax')->default(0);
            $table->integer('show_kind')->default(3);
            $table->integer('print_compound_items_in_bill')->default(0);
            $table->integer('show_compound_items_prices_in_bill')->default(0);
            $table->float('asset_value')->nullable();
            $table->float('deprecation_percent')->nullable();
            $table->float('purchase_value')->nullable();
            $table->float('deprecation_amount')->nullable();
            $table->float('scrap_amount')->nullable();
            $table->date('deprecation_start_date')->nullable();
            $table->date('purchase_date')->nullable();
            $table->boolean('apply_deprecation')->default(1);


            $table->foreignId('branch_id')->nullable()->constrained('c_branches');
            $table->foreignId('category_id')->nullable()->constrained('w_product_categories');
            $table->foreignId('unit_id')->nullable()->constrained('w_units');
            $table->foreignId('asset_status_id')->nullable()->constrained('f_asset_status');

            $table->foreignId('car_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('trailer_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('guarantee_id')->nullable()->constrained('w_guarantee');
            $table->foreignId('sales_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('resales_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('purchase_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('repurchase_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('cost_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('stock_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('product_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('deprecation_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('total_deprecation_account_id')->nullable()->constrained('temp_accounts');
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
        Schema::dropIfExists('w_products');
    }
}
