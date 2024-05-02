<?php

namespace Modules\Common\Http\Requests\Api\Languages;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class LanguageRequest extends FormRequest
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
        // Validation for code field
        $rules = [
            'code' => checkCodeValidation(request()->method(), 'c_languages', $this->system_language->id ?? null)
        ];
        // Validation for name field
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules += ['key' => 'string'];
        $rules += ['rtl' => 'nullable'];
        $rules += ['is_active' => 'nullable'];
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
