<?php

namespace Modules\Common\Http\Requests\Api\BillInstallments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BillInstallmentRequest extends FormRequest
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
            "bill_id" => "required|exists:c_bills,id",
            "installment_way" => "required|in:0,1,2",
            "period_start" => "required|numeric",
            "calc_by_hijri" => "boolean",
            "first_payment" => "between:0,99999999999999999999.99",
            "first_payment_date" => "date",
            "start_date" => "date",
            "installment_value" => "between:0,99999999999999999999.99",
            "installment_count" => "numeric",
            "details" => "required|array",
            "details.*.installment_date" => "date",
            "details.*.installment_value" => "between:0,99999999999999999999.99",
            "details.*.installment_status" => "boolean",
        ];
        $rules += validateNullableField(request()->header("languages"), "details.*.remarks", "string");
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
