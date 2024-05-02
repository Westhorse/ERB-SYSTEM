<?php

namespace Modules\Common\Database\Seeders\Area;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Area\Region;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Region::factory()->count(20000)->create();
    }
}
