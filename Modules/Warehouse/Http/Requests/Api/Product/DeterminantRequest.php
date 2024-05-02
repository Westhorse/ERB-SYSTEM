<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class DeterminantRequest extends FormRequest
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
            "code" => checkCodeValidation(request()->method(), 'w_determinants', $this->determinant->id ?? null),
            "smallint" => 'nullable',
            "max_qty" => 'nullable',
            "default_value" => 'nullable',
            "is_unique" => 'nullable',
            "is_active" => 'nullable',
            'determinantsDetail.*' => 'array',

        ];
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules += validateNullableField(request()->header('languages'), 'determinantsDetail.*.name', 'string');
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
