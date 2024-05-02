<?php

namespace Modules\Warehouse\Http\Requests\Api\Tax;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use function request;

class TaxStoreRequest extends FormRequest
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
            'code' => checkCodeValidation(request()->method(), 'c_taxes'),
            'is_active' => 'boolean',
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
