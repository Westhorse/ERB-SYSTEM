<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bill_type_id')->constrained('c_bill_types');
            $table->string('code');
            $table->string('vendor_bill_no')->nullable();
            $table->integer('bill_version')->default(1);
            $table->dateTime('bill_date');
            $table->tinyInteger('payment_type')->nullable();
            $table->integer('days_count')->default(0);
            $table->foreignId('currency_id')->constrained('c_currencies');
            $table->float('conversion_factor');
            $table->json('notes')->nullable();
            $table->foreignId('branch_business_id')->constrained('c_branches_business');
            $table->foreignId('payment_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('bill_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('ref_bill_type_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('ref_bill_id')->nullable()->constrained('c_bills');
            $table->dateTime('supply_date')->nullable();
            $table->foreignId('warehouse_id')->constrained('w_warehouses');
            $table->foreignId('cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('representative_id')->nullable()->constrained('temp_employees');
            $table->foreignId('project_id')->nullable()->constrained('temp_projects');
            $table->foreignId('customer_id')->nullable()->constrained('w_customers');
            $table->foreignId('supplier_id')->nullable()->constrained('w_suppliers');
            $table->json('remarks')->nullable();
            $table->foreignId('driver_id')->nullable()->constrained('temp_employees');
            $table->foreignId('car_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('trailer_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('shipping_policy_id')->nullable()->constrained('w_shipping_policy');
            $table->tinyInteger('shipping_type')->nullable()->default(1);
            $table->foreignId('paid_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('rest_account_id')->nullable()->constrained('temp_accounts');
            $table->float('paid_amount')->nullable();
            $table->boolean('is_active')->default(1);
            $table->float('invoice_total')->default(0.0);
            $table->float('invoice_total_tax')->default(0.0);
            $table->softDeletes();
            $table->timestamps();
        });

        DB::statement("
        CREATE OR REPLACE view bill_effect_balance as Select c_bills.id,c_bills.bill_date,c_bill_types.type_Id
         from c_bills INNER JOIN c_bill_types on c_bills.bill_type_id = c_bill_types.id
         Where  c_bill_types.stocking_effect = 0
     ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW bill_effect_balance');
        Schema::dropIfExists('c_bills');
    }
}
