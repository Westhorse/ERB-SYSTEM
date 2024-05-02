<?php

namespace Database\Seeders;

use App\Models\card\DocumentType;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DocumentType::factory()->count(20)->create();
    }
}
