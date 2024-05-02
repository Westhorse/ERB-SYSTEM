<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('c_countries')->insert(
            [
             'name_ar' => 'Country',
             'name_en' => 'Country',
           ]
        );
    }
}
