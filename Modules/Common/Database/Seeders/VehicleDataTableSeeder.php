<?php

namespace Database\Seeders;

//use App\Models\Vehicle\VehicleType;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Vehicle\VehicleData;

class VehicleDataTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleData::factory()->count(10)->create();
    }
}
