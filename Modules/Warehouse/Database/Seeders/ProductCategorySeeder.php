<?php

namespace Database\Seeders;

use App\Models\Product\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::factory()->count(10)->create();
    }
}
