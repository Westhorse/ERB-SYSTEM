<?php

namespace Database\Factories\Period;

use App\Models\Account\Account;
use App\Models\Branch\Branch;
use App\Models\Period\Period;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeriodFactory extends Factory
{
    protected $model = Period::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(11111, 55555),
            'branch_id' => Branch::factory()->create()->id,
            'account_id' => Account::factory()->create()->id,
            'name' => $this->faker->name(),
            'from_time' => $this->faker->time($format = 'H:i:s', $max = 'now'),
            'to_time' => $this->faker->time($format = 'H:i:s', $max = 'now'),
        ];
    }
}
