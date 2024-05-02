<?php

namespace Modules\Warehouse\Http\Requests\Api\Documentry;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class  DocumentryCreditExpenseTypeRequest extends FormRequest
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
    public function rules(Request $request)
    {

        $rules = [
            'code' => checkCodeValidation(request()->method(), 'w_documentry_credit_expenses_type', $this->documentry_credit_expense_type ?? null),

            'taxable' => 'nullable|boolean',
            'code_by_user' => 'nullable|boolean',
            'repeate_voucher' => 'nullable|boolean',
            'match_voucher_value' => 'nullable|boolean',
            'auto_entry_posting' => 'nullable|boolean',

            'tax_percent' => 'nullable',
            'generate_entry' => 'nullable|integer',
            'cost_distribution' => 'nullable|integer',
            'cost_effect' => 'nullable|integer',



            'tax_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],

            'opposite_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],

            'default_account_Id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
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
