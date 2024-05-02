<?php

namespace Database\Seeders;

use Database\Seeders\AssetGroup\FixedAssetGroupSeeder;
use Database\Seeders\AssetStatus\AssetStatusSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        // \App\Models\Account::factory(5)->create();
    //    \App\Models\Branch::factory(5)->create();
        // $this->call(AccountSeeder::class);
        // $this->call(GroupSeeder::class);
        $this->call(FixedAssetGroupSeeder::class);
        $this->call(AssetStatusSeeder::class);




    }
}
