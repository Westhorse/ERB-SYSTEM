<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\CarStatus\CarStatus;

class CarStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CarStatus::factory()->count(20)->create();
    }
}
