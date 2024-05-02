<?php

namespace Modules\Common\Http\Requests\Api\Bills;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class ItemRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "product_id" =>  "required|exists:w_products,id",
            // "warehouse_ids" =>  "required|array",
            // "warehouse_ids.*" =>  "required|exists:w_warehouses,id",
        ];
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
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
