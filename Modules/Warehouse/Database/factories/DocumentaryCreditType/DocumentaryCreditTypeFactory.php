<?php

namespace Database\Factories\DocumentaryCreditType;

use App\Models\DocumentaryCreditType\DocumentaryCreditType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentaryCreditTypeFactory extends Factory
{

    protected $model = DocumentaryCreditType::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => [
                'ar' => $this->faker->name . '_AR',
                'en' => $this->faker->name . '_EN',
            ],
            'code'                      => $this->faker->numberBetween(1, 9999),
            'shipping_type'             => 1,
            'shipping_policy_id'        => 1,
            'credit_ref_bill_type_id'   => 1,
            'shipping_bill_type_id'     => 1,
            'receive_bill_type_id'      => 1
        ];
    }
}
