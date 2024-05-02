<?php

namespace Database\Seeders\AssetGroup;

// use Illuminate\Database\Seeder\AssetGroup;
//use Illuminate\Database\Console\Factories\AssetGroup\FixedAssetGroupFactory;

use App\Models\AssetGroup\FixedAssetGroup;
use Illuminate\Database\Seeder;

class FixedAssetGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FixedAssetGroup::factory()->count(6)->create();
    }
}
