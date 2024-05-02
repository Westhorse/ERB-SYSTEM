<?php

namespace Database\Seeders;

use App\Models\DocumentaryCreditType\DocumentaryCreditType;
use Illuminate\Database\Seeder;

class DocumentaryCreditTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentaryCreditType::factory()->count(10)->create();
    }
}
