<?php

namespace Database\Factories\Tax;

use App\Models\Tax\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxFactory extends Factory
{
    protected $model = Tax::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(1, 9999),
            'name' => $this->faker->name(),
            'is_active' => 1,
        ];
    }
}
