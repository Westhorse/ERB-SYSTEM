<?php

namespace Database\Factories\AssetGroup;

use App\Models\AssetGroup\FixedAssetGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class FixedAssetGroupFactory extends Factory
{

    protected $model = FixedAssetGroup::class;

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

            'notes' => [
                'ar' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
                'en' => $this->faker->sentence($nbWords = 5, $variableNbWords = true),
            ],

            'group_id'     => $this->faker->numberBetween($min = 1, $max = 2),
            'account_id'   => $this->faker->numberBetween($min = 1, $max = 2),
            'branch_id'    => $this->faker->numberBetween($min = 1, $max = 2),
        ];
    }
}
