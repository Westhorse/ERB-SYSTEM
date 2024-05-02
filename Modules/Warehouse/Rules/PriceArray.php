<?php

namespace Modules\Warehouse\Rules;

use Illuminate\Contracts\Validation\Rule;

class PriceArray implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $values = collect($value)->map(function ($item) {
            return [
                'priceList_id' => $this->model,
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],

            ];
        });

        return $values->count() === $values->unique()->count();

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'هناك تكرارات في الصف';
    }
}
