<?php

namespace Modules\POS\Rules;

use Illuminate\Contracts\Validation\Rule;
use Modules\POS\Entities\Api\Branch\Branch;

class ToTimeIntersectRule implements Rule
{
    public $branchId;
    public $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($branchId, $id = null)
    {
        $this->branchId = $branchId;
        $this->id = $id;
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
        $intersect = Branch::where('id', $this->branchId)->toTimePeriodIntersects($value, $this->id)->count();

        return $intersect == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The end time intersect.';
    }
}
