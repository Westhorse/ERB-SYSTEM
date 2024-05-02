<?php

namespace Database\Factories\Tax;

use App\Models\Account;
use App\Models\Tax\Tax;
use App\Models\Tax\TaxDetail;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaxDetailFactory extends Factory
{
    protected $model = TaxDetail::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tax_id' => Tax::factory()->create()->id,
            'country_id' => 1,
            'amount_type' => $this->faker->numberBetween(0, 1),
            'amount_value' => $this->faker->numberBetween(1, 9999),
            'impact' => $this->faker->numberBetween(0, 1),
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addDays($this->faker->numberBetween(1, 10)),
            'sales_tax_account_id' => Account::factory()->create()->id,
            'purchase_tax_account_id' => Account::factory()->create()->id,
        ];
    }
}
