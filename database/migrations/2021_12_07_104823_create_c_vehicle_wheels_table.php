<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCVehicleWheelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('c_vehicle_wheels', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->nullable();
            $table->string('size')->nullable();
            $table->string('description')->nullable();
            $table->string('type')->nullable();
            $table->date('wheel_date')->nullable();
            $table->string('state')->nullable();
            $table->date('prod_date')->nullable();
            $table->string('notes')->nullable();
            $table->double('guaranty_qty')->nullable();
            $table->boolean('is_active')->default(1);
            $table->foreignId('vehicle_id')->nullable()->constrained('c_vehicle_data');
            $table->foreignId('wheel_id')->nullable()->constrained('c_wheels');
            $table->foreignId('product_id')->nullable()->constrained('w_products');
            $table->foreignId('warehouse_id')->nullable()->constrained('w_warehouses');
            $table->softDeletes();
            $table->timestamps();
        });


        $databaseName = DB::connection()->getDatabaseName();
        DB::statement("
        CREATE OR REPLACE view c_v_Vehicle_wheels  as
        SELECT c_vehicle_wheels.id,
               c_vehicle_wheels.serial_no,
               c_vehicle_wheels.size,
               c_vehicle_wheels.description,
               c_vehicle_wheels.type,
               c_vehicle_wheels.wheel_date,
               c_vehicle_wheels.state,
               c_vehicle_wheels.prod_date,
               c_vehicle_wheels.notes,
               c_vehicle_wheels.guaranty_qty,
               c_vehicle_wheels.is_active,
               c_vehicle_wheels.vehicle_id,
               c_vehicle_wheels.wheel_id,
               c_vehicle_wheels.product_id,
               c_vehicle_wheels.warehouse_id,
               c_vehicle_wheels.deleted_at,
               c_vehicle_wheels.created_at,
               c_vehicle_wheels.updated_at,
               w_products.name AS product_name,
               w_warehouses.name AS warehouse_name,
               c_wheels.name AS wheel_name
          FROM ((" . $databaseName . ".c_vehicle_wheels c_vehicle_wheels
                 LEFT OUTER JOIN " . $databaseName . ".c_wheels c_wheels
                    ON (c_vehicle_wheels.wheel_id = c_wheels.id))
                LEFT OUTER JOIN " . $databaseName . ".w_products w_products
                   ON (c_vehicle_wheels.product_id = w_products.id))
               LEFT OUTER JOIN " . $databaseName . ".w_warehouses w_warehouses
                  ON (c_vehicle_wheels.warehouse_id = w_warehouses.id)
    ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS views_c_v_Vehicle_wheels');

        Schema::dropIfExists('c_vehicle_wheels');
    }
}
