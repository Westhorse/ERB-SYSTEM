<?php

namespace Database\Seeders;

//use App\Models\Vehicle\Wheel;

use App\Models\Vehicle\Wheel;
use Illuminate\Database\Seeder;

class WheelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       Wheel::factory()->count(10)->create();
    }
}
