<?php

namespace Modules\Common\Database\Seeders;

use Database\Seeders\Area\RegionsTableSeeder;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
        /**
         * Seed the application's database.
         *
         * @return void
         */
        public function run()
        {
                // ExampleTableSeeder::class,
                $this->call([

                        // Seeders that has no required foreign keys (Step 1)
                        //     CarStatusSeeder::class,
                        //     UnitSeeder::class,
                        //     CountriesTableSeeder::class,
                            RegionsTableSeeder::class,
                        //     AccountSeeder::class,
                        //     LocalizationSeeder::class,

                        //     WarehouseSeeder::class,
                        //    ProductSeeder::class,
                        //     CostCenterSeeder::class,

                        //     VehicleDataTableSeeder::class,
                        //     VehicleTypeTableSeeder::class,
                        //     WheelTableSeeder::class,
                        //     DocumentIssuerSeeder::class,
                        //     DocumentTypeSeeder::class,
                        //     VehicleClassificationTableSeeder::class,
                        //     VehicleDocumentTableSeeder::class,
                        //     VehicleWheelTableSeeder::class,
                        // SettingSeeder::class,
                        // CTimeZoneTableSeeder::class,
                        // LanguagesTableSeeder::class
                ]);
        }
}
