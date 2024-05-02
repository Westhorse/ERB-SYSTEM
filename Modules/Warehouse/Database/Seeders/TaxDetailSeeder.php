<?php

namespace Database\Seeders;

use App\Models\Tax\TaxDetail;
use Illuminate\Database\Seeder;

class TaxDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TaxDetail::factory()->count(10)->create();
    }
}
