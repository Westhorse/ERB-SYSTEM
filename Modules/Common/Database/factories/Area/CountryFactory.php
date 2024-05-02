<?php

namespace Database\Factories\Area;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Area\Country;

class CountryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Country::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->uuid,
            'name' => ['ar' => $this->faker->name('ar'), 'en' => $this->faker->name('en')],
        ];
    }
}
