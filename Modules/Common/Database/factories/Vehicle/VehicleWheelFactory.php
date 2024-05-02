<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\VehicleWheel;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleWheelFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleWheel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'serial_no' => $this->faker->name,
            'size' => $this->faker->name,
            'description' => $this->faker->name,
            'type' => $this->faker->name,
            'wheel_date' => $this->faker->date,
            'prod_date' => $this->faker->date,
            'state' => $this->faker->name,
            'notes' => $this->faker->name,
            'guaranty_qty' => $this->faker->numberBetween(111, 6555),

            'vehicle_id' => 1,
            'wheel_id' => 1,
            'product_id' => 1,
            'warehouse_id' => 3,

            // 'vehicle_id' => 1,
            // 'wheel_id' => 1,
            // 'product_id' => 1,
            // 'warehouse_id' => 1,



        ];
    }
}
