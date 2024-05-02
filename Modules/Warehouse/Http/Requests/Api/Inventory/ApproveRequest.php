<?php

namespace Modules\Warehouse\Http\Requests\Api\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ApproveRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "in_bill_type_id" =>  "required|exists:c_bill_types,id",
            "out_bill_type_id" =>  "required|exists:c_bill_types,id",
            "date" =>  "required|date",
            "in_account_id" => "nullable|exists:temp_accounts,id",
            "out_account_id" => "nullable|exists:temp_accounts,id",
        ];
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
