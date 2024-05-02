<?php

namespace Database\Factories\Vehicle;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Vehicle\VehicleType;

class VehicleTypeFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'name_ar' =>   $this->faker->name('ar'),
            'name_en' => $this->faker->name('en'),
            'code' => $this->faker->numberBetween(11111, 55555),
            'vtype' => $this->faker->numberBetween(1, 2),

        ];
    }
}
