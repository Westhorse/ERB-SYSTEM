<?php

namespace Database\Factories\AssetStatus;

use App\Models\AssetStatus\AssetStatus;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssetStatusFactory extends Factory
{
    protected $model = AssetStatus::class;

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
            'code'      => $this->faker->randomNumber($nbDigits = null, $strict = false),
            'is_active' => $this->faker->numberBetween($min = 0, $max = 1),
            'branch_id' => $this->faker->numberBetween($min = 1, $max = 2),
        ];
    }
}
