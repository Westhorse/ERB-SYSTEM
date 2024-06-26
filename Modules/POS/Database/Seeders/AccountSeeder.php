<?php

namespace Database\Seeders;

use App\Models\Account\Account;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Account::factory()->count(10)->create();
    }
}
