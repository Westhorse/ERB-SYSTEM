<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguageShortcutSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                // English
                'shortcut' => 'en',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Arabic
                'shortcut' => 'ar',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // French
                'shortcut' => 'fr',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Italian
                'shortcut' => 'it',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Spanish
                'shortcut' => 'es',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Norwegian
                'shortcut' => 'no',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Swedish
                'shortcut' => 'sv',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Persian
                'shortcut' => 'fa',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Indonesian
                'shortcut' => 'id',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Japanase
                'shortcut' => 'ja',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Korean
                'shortcut' => 'ko',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Chinese
                'shortcut' => 'zh',
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                // Russian
                'shortcut' => 'ru',
                'created_at' => now(),
                'updated_at' => now(),

            ],
        ];

        DB::table('c_languages_shortcuts')->insert($data);
    }
}
