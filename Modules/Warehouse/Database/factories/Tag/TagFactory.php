<?php

namespace Database\Factories\Tag;

use App\Models\Tag\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{

    protected $model = Tag::class;

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
            'code'      => $this->faker->numberBetween(1, 9999),
            'is_active' => $this->faker->numberBetween(0, 1),
        ];
    }
}
