<?php

namespace Modules\Common\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class CustomTaxArray implements Rule
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
        foreach ($this->model as $key => $first_round) {
            $startDate = Carbon::createFromFormat('Y-m-d', $first_round['start_date']);
            $endDate = Carbon::createFromFormat('Y-m-d', $first_round['end_date']);
            if ($endDate->gt($startDate)) {

                foreach ($this->model as $key => $second_round) {

                    if (
                        $first_round['start_date'] != $second_round['start_date'] ||
                        $first_round['end_date'] != $second_round['end_date']
                    ) {

                        $check_start = Carbon::createFromFormat('Y-m-d', $second_round['start_date'])->between($startDate, $endDate);
                        if ($check_start) {
                            return false;
                            // return JsonResponse::respondError('The ' . $second_round['start_date'] . ' must be greater than ' . $first_round['end_date']);
                        }
                        $check_end = Carbon::createFromFormat('Y-m-d', $second_round['end_date'])->between($startDate, $endDate);
                        if ($check_end) {
                            return false;
                            // return JsonResponse::respondError('The ' . $second_round['end_date'] . ' must be greater than ' . $first_round['end_date']);
                        }
                    }
                }
            } else {
                return false;
                // return JsonResponse::respondError('The ' . $endDate . ' must be greater than ' . $startDate);
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The start_date must be greater than end_date';
    }
}
