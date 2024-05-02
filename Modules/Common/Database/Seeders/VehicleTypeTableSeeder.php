<?php

namespace Database\Seeders;

//use App\Models\Vehicle\VehicleType;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Vehicle\VehicleType;

class VehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleType::factory()->count(10)->create();
    }
}
