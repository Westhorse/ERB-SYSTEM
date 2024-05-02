<?php

namespace Database\Factories\Account;

use App\Models\Account\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    protected $model = Account::class;

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
