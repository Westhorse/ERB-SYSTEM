<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCVehicleDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_vehicle_data', function (Blueprint $table) {
            $table->id();
            $table->string('code')->nullable();
            $table->string('vtype')->nullable();
            $table->json('plate_number')->nullable();
            $table->string('model')->nullable();
            $table->integer('vehicle_kind')->nullable();
            $table->float('base_size')->nullable();
            $table->string('secret_no')->nullable();
            $table->string('prod_country')->nullable();
            $table->date('prod_date')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('color')->nullable();
            $table->float('tank_cap1')->nullable();
            $table->float('tank_cap2')->nullable();
            $table->float('weight')->nullable();
            $table->float('max_mnt_order')->nullable();
            $table->float('allowed_ex_liter')->nullable();
            $table->date('purchase_date')->nullable();
            $table->float('purchase_price')->nullable();
            $table->float('current_value')->nullable();
            $table->date('renew_date')->nullable();
            $table->string('vclass')->nullable();
            $table->float('fuel_ratio')->nullable();
            $table->float('oil_ratio')->nullable();
            $table->string('base_type')->nullable();
            $table->string('trans_license')->nullable();
            $table->string('GPS_device')->nullable();
            $table->string('ext_code')->nullable();
            $table->json('notes')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('cost_center_id')->nullable()->constrained('temp_cost_centers');
            $table->foreignId('account_id')->nullable()->constrained('temp_accounts');
            $table->foreignId('vehicle_classification_id')->nullable()->constrained('c_vehicle_classifications');
            $table->foreignId('vehicle_type_id')->nullable()->constrained('c_vehicle_types');
            $table->foreignId('car_status_id')->nullable()->constrained('c_car_status');
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
        Schema::dropIfExists('c_vehicle_data');
    }
}
