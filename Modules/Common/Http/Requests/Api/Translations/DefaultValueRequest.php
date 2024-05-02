<?php

namespace Modules\Common\Http\Requests\Api\Translations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class DefaultValueRequest extends FormRequest
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

        $rules = [];
        $rules = [
            'code' => 'required|string'
        ];
        // Validation for name field
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->label, 'label', 'string');
        $rules += ['value' => 'string'];
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
