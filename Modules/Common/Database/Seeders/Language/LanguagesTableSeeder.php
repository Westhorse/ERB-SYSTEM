<?php

namespace Database\Seeders\Language;

use Illuminate\Database\Seeder;
use Modules\Common\Entities\Api\Languages\Language;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Language::create([
            'code' => 001,
            'name' => json_encode([
                "ar" => "العربية",
                "en" => "Arabic"
            ]),
            'key' => 'ar',
        ]);
        Language::create([
            'code' => 002,
            'name' => json_encode([
                "ar" => "الإنجليزية",
                "en" => "English"
            ]),
            'key' => 'en',
        ]);
    }
}
