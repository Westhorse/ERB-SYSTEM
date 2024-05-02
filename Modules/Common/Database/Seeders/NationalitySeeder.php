<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Nationality\Nationality;

class NationalitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Nationality::factory()->count(10)->create();
    }
}
