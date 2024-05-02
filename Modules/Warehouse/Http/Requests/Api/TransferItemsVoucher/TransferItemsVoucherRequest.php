<?php

namespace Modules\Warehouse\Http\Requests\Api\TransferItemsVoucher;

use Illuminate\Foundation\Http\FormRequest;

class TransferItemsVoucherRequest extends FormRequest
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
            "voucher_date" => "date",
            "branch_business_id" => "required|exists:c_branches_business,id",
            "ref_bill_type_id" => "required|exists:c_bill_types,id",
            "ref_bill_id" => "required|exists:c_bills,id",
            "src_warehouse_id" => "required|exists:w_warehouses,id",
            "dest_warehouse_id" => "required|exists:w_warehouses,id",
            "currency_id" => "required|exists:c_currencies,id",
            "conversion_rate" => "between:0,99999999999999999999.99",
            "src_branch_id" => "required|exists:c_branches,id",
            "dest_branch_id" => "required|exists:c_branches,id",
            "in_bill_type_id" => "required|exists:c_bill_types,id",
            "out_bill_type_id" => "required|exists:c_bill_types,id",
            "deliverer_id" => "required|exists:temp_employees,id",
            "receiver_id" => "required|exists:temp_employees,id",
            "in_account_id" => "nullable|exists:temp_accounts,id",
            "out_account_id" => "nullable|exists:temp_accounts,id",
            "input_cost_center_id" => "required|exists:temp_cost_centers,id",
            "output_cost_center_id" => "required|exists:temp_cost_centers,id",
            "details" => "required|array",
            "details.*.unit_id" => "required|exists:w_units,id",
            "details.*.product_id" => "required|exists:w_products,id",
            "details.*.product_qty" => "between:0,99999999999999999999.99",
            "details.*.converted_product_qty" => "between:0,99999999999999999999.99",
            "details.*.cost_price" => "between:0,99999999999999999999.99",
        ];

        $rules += validateNullableField(request()->header("languages"), "remarks", "string");
        if (request()->method() == 'PATCH' || request()->method() == 'PUT') {
            $rules += [
                "out_bill" => "required|exists:c_bills,id",
                "in_bill" => "required|exists:c_bills,id",
            ];
        }
        return $rules;
    }
}
