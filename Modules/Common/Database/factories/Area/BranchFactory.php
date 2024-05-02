<?php

namespace Database\Factories\Area;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Area\Country;
use Modules\Common\Entities\Api\Area\Region;
use Modules\Common\Entities\Api\Currency;

class BranchFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Branch::class;


    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->uuid,
            'name' => $this->faker->name,
            'is_active' => $this->faker->numberBetween(0, 1),
            'region_id' => $this->faker->numberBetween(1, Region::count()),
            'country_id' => $this->faker->numberBetween(1, Country::count()),
            'currency_id' => $this->faker->numberBetween(1, Currency::count()),
        ];
    }
}
