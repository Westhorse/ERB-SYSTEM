<?php

namespace Database\Factories\Member;

use App\Models\Member\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;
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
            'is_active'         => true,
            'telephone'         => $this->faker->phoneNumber,
            'email'             => $this->faker->unique()->safeEmail,
            'nationality_id'    => null,
        ];
    }

}
