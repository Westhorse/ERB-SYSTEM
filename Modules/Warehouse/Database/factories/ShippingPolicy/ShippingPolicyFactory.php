<?php

namespace Database\Factories\ShippingPolicy;

use App\Models\ShippingPolicy\ShippingPolicy;
use Illuminate\Database\Eloquent\Factories\Factory;

class ShippingPolicyFactory extends Factory
{
    protected $model = ShippingPolicy::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */


    public function definition()
    {
        return [
            'code'        => $this->faker->numberBetween($min = 1, $max = 9999),
            'name' => [
                'ar' => $this->faker->name . '_AR',
                'en' => $this->faker->name . '_EN',
            ],

            'discription' => [
                'ar' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
                'en' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            ],
            'is_active' => true
        ];
    }
}
