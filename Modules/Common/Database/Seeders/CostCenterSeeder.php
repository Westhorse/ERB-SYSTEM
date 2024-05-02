<?php

namespace Database\Seeders;

use App\Models\Vehicle\CostCenter;
use Illuminate\Database\Seeder;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CostCenter::factory()->count(10)->create();
    }
}
