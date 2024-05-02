<?php

namespace Modules\Common\Http\Requests\Api\Unit;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UnitRequest extends FormRequest
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

        if (request()->method() == 'PUT' || request()->method() == 'PATCH') {
            $code =  'required|unique:c_units,code,' . $this->unit->id;
        } else {
            $code = 'required|unique:c_units,code';
        }
        return $rules = [
            'name_ar'   => 'string|required',
            'name_en'   => 'string|required',
            'is_active' => 'boolean',
            'code'      => $code
        ];

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
