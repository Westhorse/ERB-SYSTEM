<?php

namespace Database\Factories\Cashier;

use App\Models\Cashier\Cashier;
use Illuminate\Database\Eloquent\Factories\Factory;

class CashierFactory extends Factory
{
    protected $model = Cashier::class;

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
        ];
    }
}
