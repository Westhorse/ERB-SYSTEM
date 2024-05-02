<?php

namespace Modules\Common\Http\Requests\Api\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

use Illuminate\Validation\Rule;

class VehicleTypeRequest extends FormRequest
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
            'code' => checkCodeValidation(request()->method(), 'c_vehicle_types', $this->vehicle_type->id ?? null, 'vtype', request()->vtype),
            'vtype' => 'required|in:1,2',
            'is_active' => 'nullable|boolean',
        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
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
