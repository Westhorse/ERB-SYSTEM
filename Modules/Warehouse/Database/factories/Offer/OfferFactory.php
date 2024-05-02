<?php

namespace Database\Factories\Offer;

use App\Models\Offer\Offer;
use App\Models\Warehouse\Warehouse;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferFactory extends Factory
{
    protected $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "code" => $this->faker->numberBetween(11111, 55555),
            "name" => ['ar' => $this->faker->name('ar'), 'en' => $this->faker->name('en')],
            "notes" => $this->faker->sentence($nbWords = 6, $variableNbWords = true),
            "from_date" => Carbon::now(),
            "to_date" => Carbon::now()->addDays($this->faker->numberBetween(1, 5)),
            "is_active" => 1,
            "warehouse_id" => Warehouse::factory()->id,
        ];
    }
}
