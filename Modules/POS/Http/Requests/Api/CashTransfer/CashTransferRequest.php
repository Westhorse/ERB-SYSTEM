<?php

namespace Modules\POS\Http\Requests\Api\CashTransfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Modules\POS\Rules\AmountValueCashTransfer;

class CashTransferRequest extends FormRequest
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
        return [
            'src_user_id'       => 'required|integer|exists:temp_users,id',
            'src_pos_id'        => 'required|integer|exists:pos_cashiers,id',
            'src_period_id'     => 'required|integer|exists:pos_periods,id',
            'trans_date'        => 'required|date',
            'dest_user_id'      => 'required|integer|exists:temp_users,id',
            'dest_pos_id'       => 'required|integer|exists:pos_cashiers,id',
            'dest_period_id'    => 'required|integer|exists:pos_periods,id',
            'currency_id'       => 'required|integer|exists:c_currencies,id',
            'amount_value'      => ['required', new AmountValueCashTransfer()],
            'details'           => 'required|array',
            'details.*.part_id' => 'required|integer|exists:c_currencies_parts,id',
            'details.*.part_count' => 'required|integer',

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
