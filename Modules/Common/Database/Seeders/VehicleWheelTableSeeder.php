<?php

namespace Database\Seeders;

//use App\Models\Vehicle\VehicleType;

use App\Models\Vehicle\VehicleWheel;
use Illuminate\Database\Seeder;

class VehicleWheelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleWheel::factory()->count(10)->create();
    }
}
