<?php

namespace Database\Seeders;

use App\Models\Guarantee\Guarantee;
use Illuminate\Database\Seeder;

class GuaranteeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Guarantee::factory()->count(20)->create();
    }
}
