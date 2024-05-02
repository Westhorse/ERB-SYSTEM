<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\Temp\{AccountSeeder, EmployeeSeeder};


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(ExampleTableSeeder::class);
        $this->call(LocalizationSeeder::class);
        // $this->call(ProductSeeder::class);
        $this->call(EmployeeSeeder::class);
       $this->call(AccountSeeder::class);
        $this->call(UnitSeeder::class);
        // $this->call(WarehouseSeeder::class);
        // $this->call(SupplierSeeder::class);
        $this->call(TagSeeder::class);
        $this->call(CustomerSeeder::class);
        $this->call(GuaranteeSeeder::class);
        $this->call(TaxSeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(ProductCategorySeeder::class);
    }
}
