<?php

namespace Database\Seeders\Area;

use App\Models\Area\Branch;
use Illuminate\Database\Seeder;

class BranchesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Branch::factory()->count(20)->create();
    }
}
