<?php

namespace Modules\POS\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AmountValueCashTransfer implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $currencyPartsRates = [];
        $totalRateforEachPart = 1;
        if (isset(request()->details)) {
            foreach (request()->details as $detail) {
                $currencyPartRate = DB::table('c_currencies_parts')->where('id', $detail['part_id'])->pluck('rate')->first();
                if (isset($currencyPartRate)) {
                    $totalRateforEachPart = $currencyPartRate * $detail['part_count'];
                    $currencyPartsRates[] = ($totalRateforEachPart);
                }
            }
        }
        if (!empty($currencyPartsRates)) {
            $totalRateForAllCurrencyParts = array_sum($currencyPartsRates);
            return $totalRateForAllCurrencyParts == request()->amount_value;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must match the currency details';
    }
}
