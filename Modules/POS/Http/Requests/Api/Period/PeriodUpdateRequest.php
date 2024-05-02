<?php

namespace Modules\POS\Http\Requests\Api\Period;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Modules\POS\Rules\FromTimeIntersectRule;
use Modules\POS\Rules\ToTimeIntersectRule;

class PeriodUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => checkCodeValidation(request()->method(), 'pos_periods', $this->period->id),
            "from_time" => ["required", "before:to_time", new FromTimeIntersectRule($this->branch_id, $this->period->id)],
            "to_time" => ["required", "after:from_time", new ToTimeIntersectRule($this->branch_id, $this->period->id)],
            'account_id' => "required",
            'branch_id' => "required",
            'is_active' => 'nullable|boolean',
        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');

        return $rules;
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = new JsonResponse([
            'message' => 'The given data is invalid',
            'errors' => $validator->errors(),
            'status' => 422
        ]);

        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
