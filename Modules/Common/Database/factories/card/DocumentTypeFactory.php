<?php

namespace Database\Factories\card;


use App\Models\card\DocumentType;
use Illuminate\Database\Eloquent\Factories\Factory;

class DocumentTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = DocumentType::class;

    public function definition()
    {
        return [
            'name_ar' => $this->faker->name('ar'),
            'name_en' => $this->faker->name('en'),
            'code' => $this->faker->numberBetween(11111, 55555),
            'days_count' => $this->faker->numberBetween(1, 7),
            'dtype' => 1,
            'follow_renewal' => 1,
        ];

    }
}
