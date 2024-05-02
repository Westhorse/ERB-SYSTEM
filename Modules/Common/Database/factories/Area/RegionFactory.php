<?php

namespace Modules\Common\Database\Factories\Area;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Area\Region;

class RegionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Region::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->country . '_AR',
                'en' => $this->faker->country . '_EN',
            ],
            'is_active' => 1,
            'code'      => $this->faker->numberBetween(1, 9999),
        ];
    }
}
