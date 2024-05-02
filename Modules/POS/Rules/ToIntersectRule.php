<?php

namespace Modules\POS\Rules;
use Illuminate\Contracts\Validation\Rule;
use Modules\POS\Entities\Api\PointSection\PointSection;

class ToIntersectRule implements Rule
{
    public $pointsectionId;
    public $id;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id = null)
    {
       
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
        $intersect = PointSection::toPeriodIntersects($value,$this->id)->count();
        return $intersect == 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The section_to intersect.';
    }
}
