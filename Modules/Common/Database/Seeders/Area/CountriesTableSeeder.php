<?php

namespace Database\Seeders\Area;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Area\Country;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->count(20)->create();
    }
}
