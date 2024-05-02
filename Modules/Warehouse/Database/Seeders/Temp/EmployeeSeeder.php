<?php

namespace Database\Seeders\Temp;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployeeSeeder extends Seeder
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

                'name_ar' => 'الموظف الاول',
                'name_en' => 'employee one',

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'name_ar' => 'الموظف الثانى',
                'name_en' => 'employee two',

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('temp_employees')->insert($data);
    }
}
