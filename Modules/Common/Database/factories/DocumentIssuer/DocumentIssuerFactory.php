<?php

namespace Database\Factories\DocumentIssuer;


use App\Models\DocumentIssuer\DocumentIssuer;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentIssuerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = DocumentIssuer::class;

    public function definition()
    {
        return [
            'name' => ['ar' => $this->faker->name('ar'), 'en' => $this->faker->name('en')],

            'code' => $this->faker->numberBetween(11111, 55555),

        ];
    }
}
