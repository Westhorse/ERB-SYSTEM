<?php

namespace Database\Seeders\AssetStatus;

// use Illuminate\Database\Seeder\AssetGroup;
//use Illuminate\Database\Console\Factories\AssetGroup\FixedAssetGroupFactory;

use App\Models\AssetStatus\AssetStatus;
use Illuminate\Database\Seeder;

class AssetStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AssetStatus::factory()->count(30)->create();
    }
}
