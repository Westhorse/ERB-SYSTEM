<?php

namespace Database\Factories\Product;

use App\Models\Account;
use App\Models\Product\ProductCategory;
use App\Models\Tax\Tax;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoryFactory extends Factory
{
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->numberBetween(1, 9999),
            'branch_id' => 1,
            'name' => $this->faker->name,
            'unit_id' => 1,
            'notes' => $this->faker->text(),
            'is_active' => 1,
            'taxable' => 0,
            'is_active' => 1,
            'cost_way' => $this->faker->numberBetween(0, 4),
            'apply_tax' => $this->faker->numberBetween(0, 2),
            'product_type' => $this->faker->numberBetween(0, 4),
            'cash_commission' => $this->faker->numberBetween(1, 100),
            'later_commission' => $this->faker->numberBetween(1, 100),
            'commission_type' => $this->faker->numberBetween(0, 1),
            'purchase_disc_type' => $this->faker->numberBetween(0, 1),
            'purchase_disc_amount_type' => $this->faker->numberBetween(0, 1),
            'purchase_disc_amount' => $this->faker->numberBetween(1, 100),
            'cost_price_effect' => $this->faker->numberBetween(0, 4),
            'buy_free_percent' => $this->faker->numberBetween(1, 100),
            'sale_disc_type' => $this->faker->numberBetween(0, 4),
            'sale_disc_amount_type' => $this->faker->numberBetween(0, 4),
            'sale_disc_amount' => $this->faker->numberBetween(1, 100),
            'sale_free_percent' => $this->faker->numberBetween(1, 100),
            'sales_account_id' => 1,
            'resales_account_id' => 1,
            'purchase_account_id' => 1,
            'repurchase_account_id' => 1,
            'cost_account_id' => 1,
            'stock_account_id' => 1,

        ];
    }
}
