<?php

namespace Database\Seeders;

//use App\Models\Vehicle\VehicleType;

use App\Models\Vehicle\VehicleDocument;
use Illuminate\Database\Seeder;

class VehicleDocumentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        VehicleDocument::factory()->count(10)->create();
    }
}
