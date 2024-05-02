<?php

namespace Database\Seeders;

use App\Models\DocumentIssuer\DocumentIssuer;
use Illuminate\Database\Seeder;

class DocumentIssuerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentIssuer::factory()->count(20)->create();
    }
}
