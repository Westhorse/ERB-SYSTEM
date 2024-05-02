<?php

namespace Database\Factories\Unit;

use App\Models\Unit\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'name_ar'   => $this->faker->name,
            'name_en'   => $this->faker->name,
            'is_active' => $this->faker->numberBetween(0, 1),
            'code'      => $this->faker->numberBetween(1, 9999),
        ];
    }
}
