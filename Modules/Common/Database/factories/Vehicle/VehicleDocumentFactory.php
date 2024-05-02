<?php

namespace Database\Factories\Vehicle;

use App\Models\Vehicle\VehicleDocument;

use Illuminate\Database\Eloquent\Factories\Factory;

class VehicleDocumentFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = VehicleDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [

            'doc_serial' => $this->faker->name,
            'start_date' => $this->faker->date,
            'end_date' => $this->faker->date,
            'notes' => $this->faker->name,
            'value' => $this->faker->numberBetween(11111, 55555),
            'vehicle_data_id' => $this->faker->numberBetween(1, 5),
            'document_type_id' =>1,
            'document_issuer_id' => $this->faker->numberBetween(1, 10),


        ];
    }
}
