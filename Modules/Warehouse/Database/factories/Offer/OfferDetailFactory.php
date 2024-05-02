<?php

namespace Database\Factories\Offer;

use App\Models\Offer\Offer;
use App\Models\Offer\OfferDetail;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

class OfferDetailFactory extends Factory
{
    protected $model = OfferDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kind' => $this->faker->numberBetween(1, 3),
            'required_qty' => $this->faker->numberBetween(1, 100),
            'offer_qrt' => $this->faker->numberBetween(1, 100),
            'max_offer_qty' => $this->faker->numberBetween(1, 100),
            'item_price' => $this->faker->numberBetween(1, 100),
            'discount_percent' => $this->faker->numberBetween(1, 100),
            'free_qty' => $this->faker->numberBetween(1, 100),
            'offer_id' => Offer::factory()->id,
            'product_id' => Product::factory()->id,
            "warehouse_id" => Warehouse::factory()->id,
        ];
    }
}
