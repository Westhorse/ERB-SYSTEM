<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WarehouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [

                'name_ar' => 'المخزن الاول',
                'name_en' => 'warehouse one',


                "address" => "عنوان تجريبى",


                "notes" => "ملاحظات تجربيه",



                "code" => 125,
                "fp_account_id" => 1,
                "lp_account_id" => 2,

                'is_active' => true,
                "effect_in_store_value" => true,

                "district_id" => 1,
                "branch_id" => null,
                "in_bill_type_id" => 1,
                "out_bill_type_id" => 2,
                "warehouse_keeper_id" => 1,
                "driver_id" => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'name_ar' => 'المخزن الثانى',
                'name_en' => 'warehouse two',


                "address" => "عنوان تجريبى",


                "notes" => "ملاحظات تجربيه",

                "code" => 125,
                "fp_account_id" => 1,
                "lp_account_id" => 2,

                'is_active' => true,
                "effectInStoreValue" => true,

                "district_id" => 1,
                "branch_id" => 1,
                "in_bill_type_id" => 1,
                "out_bill_type_id" => 2,
                "warehouse_keeper_id" => 1,
                "driver_id" => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('w_warehouses')->insert($data);
    }
}
