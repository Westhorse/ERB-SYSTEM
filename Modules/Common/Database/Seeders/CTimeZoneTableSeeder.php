<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CTimeZoneTableSeeder extends Seeder
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

                'diff' => -12,
                'name' => 'UTC-12:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -11,
                'name' => 'UTC-11:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -10,
                'name' => 'UTC-10:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -9,
                'name' => 'UTC-09:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -8,
                'name' => 'UTC-08:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -7,
                'name' => 'UTC-07:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -6,
                'name' => 'UTC-06:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -5,
                'name' => 'UTC-05:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -4,
                'name' => 'UTC-04:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -3,
                'name' => 'UTC-03:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -2,
                'name' => 'UTC-02:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => -1,
                'name' => 'UTC-01:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 0,
                'name' => 'UTC+00:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 1,
                'name' => 'UTC+01:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 2,
                'name' => 'UTC+02:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 3,
                'name' => 'UTC+03:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 4,
                'name' => 'UTC+04:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 5,
                'name' => 'UTC+05:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 6,
                'name' => 'UTC+06:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 7,
                'name' => 'UTC+07:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 8,
                'name' => 'UTC+08:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 9,
                'name' => 'UTC+09:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 10,
                'name' => 'UTC+10:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 11,
                'name' => 'UTC+11:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 12,
                'name' => 'UTC+12:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 13,
                'name' => 'UTC+13:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [

                'diff' => 14,
                'name' => 'UTC+14:00',
                'created_at' => now(),
                'updated_at' => now(),
            ],


        ];
        
        DB::table('c_time_zone')->insert($data);
    
    }
}
