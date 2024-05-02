<?php

namespace Database\Factories\Supplier;

use App\Models\Supplier\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SupplierFactory extends Factory
{
    protected $model = Customer::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => ['ar' => $this->faker->name('ar'), 'en' => $this->faker->name('en')],
            'telephone' => $this->faker->numberBetween(11111, 55555),
            'fax_number' => $this->faker->numberBetween(11111, 55555),
            'tax_number' => $this->faker->numberBetween(11111, 55555),
            'address' => $this->faker->numberBetween(11111, 55555),
            'code' => $this->faker->numberBetween(11111, 55555),
            'account_id' =>1,

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
