<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCBillTypesUsersSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_bill_types_users_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->foreignId('warehouse_id')->nullable();
            $table->foreignId('employee_id')->nullable()->constrained('temp_employees');
            $table->foreignId('cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('project_id')->nullable()->constrained('temp_projects');
            $table->foreignId('discount_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('opposite_discount_account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('reference_id')->nullable()->constrained('c_bill_types');
            $table->foreignId('pos_id')->nullable()->constrained('pos_cashiers');
            $table->tinyInteger('payment_type')->nullable();
            $table->smallInteger('default_price')->default(1);
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
        Schema::dropIfExists('c_bill_types_users_settings');
    }
}

