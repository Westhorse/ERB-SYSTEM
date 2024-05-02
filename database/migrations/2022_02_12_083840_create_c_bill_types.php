<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->nullable()->constrained('c_branches');
            $table->foreignId('group_id')->nullable()->constrained('c_bill_types_groups');
            $table->smallInteger('type_id')->nullable();
            $table->bigInteger('payment_voucher_id')->nullable();
            $table->foreignId('currency_id')->nullable()->constrained('c_currencies');
            $table->foreignId('accumulated_bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('change_bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('offer_id')->nullable()->constrained('w_offers');
            $table->foreignId('transfer_warehouse_id')->nullable()->constrained('w_warehouses');
            $table->foreignId('in_bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('out_bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('transfer_branch_id')->nullable()->constrained('c_branches');
            $table->foreignId('cost_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('stock_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('donate_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('discount_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('add_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('paid_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('rest_amount_account_id')->nullable()->constrained('temp_accounts');
            $table->json('name')->nullable();
            // خصائص أساسية
            $table->smallInteger('stocking_effect')->nullable();
            $table->tinyInteger('cost_price_effect')->default(0);
            $table->tinyInteger('discount_cost_price_effect')->default(0);
            $table->tinyInteger('add_cost_price_effect')->default(0);
            $table->smallInteger('distribution_type')->nullable();
            $table->smallInteger('accounting_effect')->default(2);
            $table->tinyInteger('automatic_accounting_posting')->default(0);
            $table->smallInteger('bill_section')->default(1);
            $table->tinyInteger('compound_Journal')->default(0);
            $table->tinyInteger('sum_debit_acc')->default(0);
            $table->tinyInteger('sum_credit_acc')->default(0);
            $table->tinyInteger('load_generated_journal')->default(0);
            $table->tinyInteger('exchange_expenses_income_acc')->default(0);
            $table->tinyInteger('exchange_product_stock_acc')->default(0);
            $table->tinyInteger('post_bill_cost')->default(0);
            $table->tinyInteger('account_balance')->default(0);
            $table->tinyInteger('automatic_save_bill')->default(0);
            $table->tinyInteger('allow_selling_non_entry_serial')->default(0);
            $table->tinyInteger('random_serials')->default(0);
            $table->tinyInteger('ignore_product_add_discount')->default(0);
            $table->tinyInteger('cost_center_mandatory')->default(0);
            $table->tinyInteger('representative_mandatory')->default(0);
            $table->tinyInteger('multi_version')->default(0);
            $table->tinyInteger('code_per_user')->default(1);
            //خيارات إضافية
            $table->integer('time_limit')->nullable();
            $table->tinyInteger('cost_center_type')->default(1);
            $table->integer('qty_approximation_digits')->nullable();
            $table->integer('amount_approximation_digits')->nullable();
            $table->tinyInteger('barcode_search')->default(0);
            $table->tinyInteger('output_oldest_expire_date')->default(0);
            $table->tinyInteger('output_expire_date_purchase_date')->default(0);
            $table->tinyInteger('expire_date_purchase_discount')->default(0);
            $table->tinyInteger('edit_item_qty')->default(0);
            $table->tinyInteger('update_query')->default(0);
            $table->tinyInteger('product_category_filter')->default(0);
            $table->tinyInteger('contact_filter_by_company')->default(0);
            $table->tinyInteger('use_smpile_bill')->default(0);
            $table->tinyInteger('calculate_compound_price')->default(0);
            $table->tinyInteger('consider_payment_value_in_Bill_paid')->default(0);
            $table->tinyInteger('use_price_from_last_offer')->default(0);
            $table->tinyInteger('use_price_list')->default(0);
            $table->tinyInteger('discount_qty_as_percent')->default(0);
            $table->tinyInteger('add_qty_as_percent')->default(0);
            $table->tinyInteger('payment_terms_with_net_invoice')->default(0);
            $table->tinyInteger('open_drawer_with_add')->default(0);
            $table->tinyInteger('pirce_modification_with_total_modification')->default(0);
            $table->tinyInteger('connect_with_customs_transaction')->default(0);
            $table->float('max_item_qty')->nullable();
            $table->tinyInteger('company_filter_acc')->default(0);
            $table->tinyInteger('use_touch_screen')->default(0);
            $table->tinyInteger('connect_with_employee_vehicle')->default(0);
            $table->tinyInteger('modify_vehicle_weight')->default(0);
            $table->tinyInteger('use_default_warehouse')->default(0);
            $table->tinyInteger('generate_voucher_to_warehouse')->default(0);
            $table->tinyInteger('normal_price_color')->default(0);
            $table->tinyInteger('min_cost_price_color')->default(0);
            $table->tinyInteger('min_sell_price_color')->default(0);
            $table->tinyInteger('negative_qty_color')->default(0);
            $table->tinyInteger('exceed_min_limit_color')->default(0);
            $table->tinyInteger('exceed_max_limit_color')->default(0);
            $table->tinyInteger('exceed_zero_qty_color')->default(0);
            $table->tinyInteger('price_from_offers_color')->default(0);
            //الضريبة
            $table->tinyInteger('tax_exemption')->default(0);
            $table->tinyInteger('manual_tax_entry')->default(0);
            $table->tinyInteger('tax_base')->default(1);
            //فاتورة المناقلة
            $table->tinyInteger('generate_transfer_bill')->default(0);
            $table->tinyInteger('show_transfer_bill')->default(0);
            $table->smallInteger('transfer_price')->default(1);
            //المراجع
            $table->tinyInteger('hide_closed_ref')->default(0);
            $table->tinyInteger('confirm_ref')->default(0);
            $table->bigInteger('default_ref')->nullable();
            $table->tinyInteger('choose_customer_before_ref')->default(0);
            $table->tinyInteger('delete_bill_ref')->default(0);
            $table->tinyInteger('update_prices_from_bill_prices')->default(0);
            $table->tinyInteger('add_to_exist_items')->default(0);
            $table->tinyInteger('hide_services_items')->default(0);
            $table->tinyInteger('automatic_load_items')->default(0);
            $table->tinyInteger('apply_ref_discount')->default(0);
            $table->tinyInteger('apply_ref_qty_discount')->default(0);
            $table->tinyInteger('show_ref_of_ref')->default(0);
            $table->tinyInteger('show_ref_number')->default(0);
            $table->tinyInteger('choose_multi_ref')->default(0);
            $table->tinyInteger('save_ref_number')->default(0);
            $table->tinyInteger('add_ref_info')->default(0);
            $table->tinyInteger('update_expire_date')->default(0);
            $table->tinyInteger('get_bill_ref')->default(0);
            $table->tinyInteger('get_remakrs')->default(0);
            $table->tinyInteger('get_payment_conditions')->default(0);
            $table->tinyInteger('get_table_warehouse')->default(0);
            $table->tinyInteger('get_add_discount')->default(0);
            $table->tinyInteger('get_ref_voucher')->default(0);
            $table->tinyInteger('get_voucher_values_without_tax')->default(0);
            $table->tinyInteger('get_cost_centers')->default(0);
            $table->tinyInteger('get_main_warehouse')->default(0);
            $table->tinyInteger('get_payment_way')->default(0);
            $table->tinyInteger('get_ref_branch')->default(0);
            $table->tinyInteger('get_table_remarks')->default(0);
            $table->tinyInteger('get_account')->default(0);
            $table->tinyInteger('get_bill_ref_number')->default(0);
            $table->tinyInteger('get_time_limit')->default(0);
            $table->tinyInteger('search_in_ref_items')->default(0);
            $table->tinyInteger('search_in_opened_ref_items')->default(0);
            $table->tinyInteger('get_additional_data')->default(0);
            $table->tinyInteger('get_additional_fields')->default(0);
            $table->tinyInteger('recalculate_tax')->default(0);
            $table->tinyInteger('determinants_replacement')->default(0);
            $table->boolean('is_active')->default(1);

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
        Schema::dropIfExists('c_bill_types');
    }
}
