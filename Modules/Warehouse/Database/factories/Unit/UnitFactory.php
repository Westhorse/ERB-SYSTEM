<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

class UnitFactory extends Factory
{

    protected $model = Unit::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->name . '_AR',
                'en' => $this->faker->name . '_EN',
            ],
            'is_active' => 1,
            'code'      => $this->faker->numberBetween(1, 9999),
        ];
    }
}
