<?php

namespace Database\Seeders;

use App\Models\Tax\Tax;
use Illuminate\Database\Seeder;

class TaxSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tax::factory()->count(10)->create();
    }
}
