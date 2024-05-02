<?php

namespace Database\Factories\Vehicle;


use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Common\Entities\Api\Vehicle\VehicleData;

class VehicleDataFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleData::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [

            'code' => $this->faker->numberBetween(11111, 55555),
            'vtype' => $this->faker->numberBetween(1, 2),
            'plate_number_en' => $this->faker->numberBetween(11111, 55555),
            'plate_number_ar' => $this->faker->numberBetween(11111, 55555),
            'model' => $this->faker->numberBetween(11111, 55555),
            'vehicle_kind' => $this->faker->numberBetween(0,1),
            'base_size' => $this->faker->numberBetween(11111, 55555),
            'secret_no' => $this->faker->numberBetween(11111, 55555),
            'prod_country' => $this->faker->numberBetween(11111, 55555),
            'prod_date' => $this->faker->date,
            'chassis_no' => $this->faker->numberBetween(11111, 55555),
            'color' => $this->faker->name,
            'tank_cap1' => $this->faker->numberBetween(11111, 55555),
            'tank_cap2' => $this->faker->numberBetween(11111, 55555),
            'weight' => $this->faker->numberBetween(11111, 55555),
            'max_mnt_order' => $this->faker->numberBetween(11111, 55555),
            'allowed_ex_liter' => $this->faker->numberBetween(11111, 55555),
            'purchase_date' => $this->faker->date,
            'purchase_price' => $this->faker->numberBetween(11111, 55555),
            'current_value' => $this->faker->numberBetween(11111, 55555),
            'renew_date' => $this->faker->date,
            'vclass' => $this->faker->numberBetween(11111, 55555),
            'fuel_ratio' => $this->faker->numberBetween(11111, 55555),
            'oil_ratio' => $this->faker->numberBetween(11111, 55555),
            'base_type' => $this->faker->name,
            'trans_license' => $this->faker->name,
            'GPS_device' => $this->faker->name,
            'ext_code' => $this->faker->name,
            'notes' => $this->faker->name,

            'cost_center_id' => 1,
            'account_id' =>1,
            'vehicle_classification_id' => $this->faker->numberBetween(1, 10),
            'vehicle_type_id' =>1,
            'car_status_id' => $this->faker->numberBetween(1, 10),




        ];
    }
}
