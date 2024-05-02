<?php

namespace Database\Factories\CarStatus;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\CarStatus\CarStatus;

class CarStatusFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = CarStatus::class;

    public function definition()
    {
        return [
            'name' => ['ar' => $this->faker->name('ar'), 'en' => $this->faker->name('en')],

            'code' => $this->faker->numberBetween(11111, 55555),
        ];
    }
}
