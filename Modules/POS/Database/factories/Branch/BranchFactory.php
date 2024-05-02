<?php

namespace Database\Factories\Branch;

use App\Models\Branch\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;

class BranchFactory extends Factory
{
    protected $model = Branch::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(11111, 55555),
            'name' => $this->faker->name(),
            'region_id' => 1,
            'country_id' => 1,
            'currency_id' => 1,
        ];
    }
}
