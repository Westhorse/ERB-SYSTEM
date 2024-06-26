<?php

namespace Database\Seeders;

use App\Models\Period\Period;
use Illuminate\Database\Seeder;

class PeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Period::factory()->count(10)->create();
    }
}
