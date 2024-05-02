<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocalizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {





        $branchData = [
            [
                'code'=>'555',
                'name_ar' => 'الفرع الاول',
                'name_en' => 'first branch',


                // 'district_id' => 1,
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code'=>'3333',
                'name_ar' => 'الفرع الثانى',
                'name_en' => 'second branch',

                'is_active' => true,

                // 'district_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('w_branches')->insert($branchData);
    }
}
