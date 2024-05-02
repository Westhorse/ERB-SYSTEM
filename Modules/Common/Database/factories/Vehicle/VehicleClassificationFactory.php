<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\VehicleClassification;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleClassificationFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleClassification::class;

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

        ];
    }
}
