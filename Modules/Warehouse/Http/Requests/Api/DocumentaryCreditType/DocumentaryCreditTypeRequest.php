<?php

namespace Modules\Warehouse\Http\Requests\Api\DocumentaryCreditType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;



class DocumentaryCreditTypeRequest extends FormRequest
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
            'shipping_type' => 'nullable|integer',
            'code' => checkCodeValidation(request()->method(), 'w_documentary_credit_types', $this->documentary_credit_type->id ?? null),

            'shipping_policy_id' => [
                'nullable',
                Rule::exists('w_shipping_policy', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'credit_ref_bill_type_id' => [
                'required',
                Rule::exists('c_bill_types', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'shipping_bill_type_id' => [
                'required',
                Rule::exists('c_bill_types', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'receive_bill_type_id' => [
                'required',
                Rule::exists('c_bill_types', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
        ];

        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
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
