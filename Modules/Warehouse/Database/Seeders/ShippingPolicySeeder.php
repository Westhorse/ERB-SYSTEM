<?php

namespace Database\Seeders;

use App\Models\ShippingPolicy\ShippingPolicy;
use Illuminate\Database\Seeder;

class ShippingPolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ShippingPolicy::factory()->count(5)->create();
    }
}
