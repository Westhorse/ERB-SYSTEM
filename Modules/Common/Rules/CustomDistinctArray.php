<?php

namespace Modules\Common\Rules;

use Illuminate\Contracts\Validation\Rule;

class CustomDistinctArray implements Rule
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
                'from_currency_id' => $this->model,
                'to_currency_id' => $item['to_currency_id'],
                'exchange_date' => $item['exchange_date'],

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
        return 'There are duplicates in exchange';
    }
}
