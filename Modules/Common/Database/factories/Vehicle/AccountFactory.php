<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\Account;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Account::class;
    public function definition()
    {
        return [
            'name_ar' => $this->faker->name('ar'),
            'name_en' => $this->faker->name('en'),
        ];
    }
}
