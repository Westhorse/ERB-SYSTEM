<?php

namespace Database\Factories\Nationality;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Nationality\Nationality;

class NationalityFactory extends Factory
{

    protected $model = Nationality::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'      => [
                'ar' => $this->faker->name . '_AR',
                'en' => $this->faker->name . '_EN'
            ],
            'code'      => $this->faker->numberBetween(1, 9999),
            'is_active' => $this->faker->numberBetween(0, 1)
        ];
    }
}
