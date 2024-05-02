<?php

namespace Modules\Common\Http\Requests\Api\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class PaymentTypeRequest extends FormRequest
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
       
        if (request()->fees_type == '1') {
            $fees_type = 'nullable|numeric|max:100';
        }else {
            $fees_type = 'nullable';
        }

        $rules = [
            'code' => checkCodeValidation(request()->method(), 'c_payment_types', $this->payment_type->id ?? null),

            "fees_type" => "nullable|boolean",
            'fees_value' => $fees_type,
            'max_fees_value' => 'nullable',
            'tax_percent' => 'nullable',
            'temp_account_id' => 'nullable',
            'fees_account_id' => 'nullable',
            'tax_account_id' => 'nullable',
            "is_active" => "nullable|boolean",

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
