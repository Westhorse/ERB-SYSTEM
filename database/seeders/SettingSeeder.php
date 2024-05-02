<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
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

                'setting_id' => 0,
                'setting_name' => 'Database_Version',
                "setting_value" => json_encode(['en' => '1.0.0']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 1,
                'setting_name' => 'Shortcut',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 2,
                'setting_name' => 'Company_Name',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 3,
                'setting_name' => 'Telephone_1',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 4,
                'setting_name' => 'Telephone_2',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5,
                'setting_name' => 'Fax',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 6,
                'setting_name' => 'Mobile_1',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 7,
                'setting_name' => 'Mobile_2',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 8,
                'setting_name' => 'Mail_box',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 9,
                'setting_name' => 'Postal_code',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 10,
                'setting_name' => 'City',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 11,
                'setting_name' => 'Tax_number',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 12,
                'setting_name' => 'Address',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [

                'setting_id' => 13,
                'setting_name' => 'Website',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 14,
                'setting_name' => 'Email_Address',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 15,
                'setting_name' => 'Logo',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'setting_id' => 4001,
                'setting_name' => 'Point_Value',
                "setting_value" => json_encode([]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5001,
                'setting_name' => 'UnCalculate_Asset_Depreciation',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5002,
                'setting_name' => 'Search_In_All_Accounts',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5003,
                'setting_name' => 'Calculate_Depreciation_With_Hijri_Date',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5004,
                'setting_name' => 'Calculate_Depreciation_By',
                "setting_value" => json_encode(["en"=> 1, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5005,
                'setting_name' => 'Depreciation_Days_Count',
                "setting_value" => json_encode(["en"=> 365, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5006,
                'setting_name' => 'Related_Assets_With_Open_Entry',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5007,
                'setting_name' => 'Relate_By_Net_Values',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5008,
                'setting_name' => 'Balance_additions_and_exclusions',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5009,
                'setting_name' => 'Exclude_scrap_value_when_calculating_the_annual_depreciation',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5010,
                'setting_name' => 'Exclude_total_value_when_calculating_the_annual_depreciation',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5011,
                'setting_name' => 'Monthly_Deprecation_Assets_Generate_Auto_Entry',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'setting_id' => 5012,
                'setting_name' => 'Monthly Deprecation Assets Auto Posted',
                "setting_value" => json_encode(["en"=> 0, "ar"=>""]),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('c_settings')->insert($data);
    }
}
