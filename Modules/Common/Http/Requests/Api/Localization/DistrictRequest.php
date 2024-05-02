<?php

namespace Modules\Common\Http\Requests\Api\Localization;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class DistrictRequest extends FormRequest
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

        if ($this->isMethod('patch')) {
            $code = 'required|unique:c_districts,code,' . $this->district->id;
        } else {
            $code = ['required', Rule::unique('c_districts')];
        }
        
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');
        
        $rules += ["is_active" => 'nullable', 'code' => $code];
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
