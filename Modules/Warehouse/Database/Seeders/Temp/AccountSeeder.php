<?php

namespace Database\Seeders\Temp;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AccountSeeder extends Seeder
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
                'code' => 'ARA1',
                'name_ar' => 'الحساب الاول',
                'name_en' => 'accounting one',

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ARA1',
                'name_ar' => 'الحساب الثانى',
                'name_en' => 'accounting two',

                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('temp_accounts')->insert($data);
    }
}
