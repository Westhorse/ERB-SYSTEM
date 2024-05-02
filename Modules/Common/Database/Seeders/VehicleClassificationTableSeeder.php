<?php

namespace Database\Seeders;

//use App\Models\Vehicle\VehicleType;

use App\Models\Vehicle\VehicleClassification;
use Illuminate\Database\Seeder;

class VehicleClassificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleClassification::factory()->count(10)->create();
    }
}
