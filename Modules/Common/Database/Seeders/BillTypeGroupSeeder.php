<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\BillTypeGroup\BillTypeGroup;

class BillTypeGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        BillTypeGroup::factory()->count(10)->create();
    }
}
