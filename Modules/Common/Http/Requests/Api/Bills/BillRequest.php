<?php

namespace Modules\Common\Http\Requests\Api\Bills;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class BillRequest extends FormRequest
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
            "invoice_total" => "nullable",
            "invoice_total_tax" => "nullable",
            "main.code" => checkCodeValidation(request()->method(), "c_bills", $this->bill->id ?? null, "bill_version", request('main.bill_version')),
            "main.bill_type_id" => "exists:c_bill_types,id",
            "main.vendor_bill_no" => "nullable|string",
            "main.bill_version" => "required|numeric",
            "main.bill_date" => "date",
            "main.payment_type" => "required|in:1,2,3",
            "main.days_count" => "numeric",
            "main.currency_id" => "exists:c_currencies,id",
            "main.conversion_factor" => "nullable|numeric",
            "main.paid_amount" => "nullable|numeric",
            "main.shipping_type" => "nullable|numeric",
            "main.payment_account_id" => "exists:temp_accounts,id",
            "main.bill_account_id" => "exists:temp_accounts,id",
            "main.driver_id" =>  "nullable|exists:temp_employees,id",
            "main.car_id" => "nullable|exists:c_vehicle_data,id",
            "main.shipping_policy_id" => "nullable|exists:w_shipping_policy,id",
            "main.branch_business_id" => "nullable|exists:c_branches_business,id",
            "main.paid_account_id" => "nullable|exists:temp_accounts,id",
            "main.rest_account_id" => "nullable|exists:temp_accounts,id",
            "main.ref_bill_type_id" => "nullable|exists:c_bill_types,id",
            "main.ref_bill_id" =>  "nullable|exists:c_bill_types,id",
            "main.supply_date" => "nullable|date",
            "main.warehouse_id" =>  "exists:w_warehouses,id",
            "main.cost_center_id" => "nullable|exists:temp_cost_centers,id",
            "main.representative_id" => "nullable|exists:temp_employees,id",
            "main.project_id" =>  "nullable|exists:temp_projects,id",
            "main.customer_id" =>  "nullable|exists:w_customers,id",
            "main.supplier_id" =>  "nullable|exists:w_suppliers,id",
            "main.trailer_id" => "nullable|exists:c_vehicle_data,id",

            "bills_items" => "array|required",
            "bills_items.*.warehouse_id" => "exists:w_warehouses,id",
            "bills_items.*.product_id" => "exists:w_products,id",
            "bills_items.*.unit_id" => "exists:w_units,id",
            "bills_items.*.add_qty" => "nullable",
            "bills_items.*.converted_add_qty" => "nullable",
            "bills_items.*.issue_qty" => "nullable",
            "bills_items.*.converted_issue_qty" => "nullable",
            "bills_items.*.unit_price" => "nullable",
            "bills_items.*.total_price" => "nullable",
            "bills_items.*.total_price_with_tax" => "nullable",
            "bills_items.*.is_active" => "nullable",

            "bills_items.*.bill_items_taxes" => "array",
            "bills_items.*.bill_items_taxes.*.tax_id" => "exists:c_taxes,id",
            "bills_items.*.bill_items_taxes.*.tax_percent" => "nullable|numeric",
            "bills_items.*.bill_items_taxes.*.tax_value" => "nullable|numeric",

            "bill_effects" => "array",
            "bill_effects.*.effect_type" => "numeric",
            "bill_effects.*.effect_value" => "numeric",
            "bill_effects.*.effect_amount_type" => "numeric",
            "bill_effects.*.effect_amount" => "numeric",
            "bill_effects.*.account_id" => "nullable|exists:temp_accounts,id",
            "bill_effects.*.opposite_account_id" => "nullable|exists:temp_accounts,id",
            "bill_effects.*.currency_id" => "nullable|exists:c_currencies,id",
            "bill_effects.*.conversion_factor" => "nullable|numeric",
            "bill_effects.*.reference" => "nullable|string",
            "bill_effects.*.reference_no" => "nullable|string",

            "bill_payment_terms" => "array",
            "bill_payment_terms.*.payment_amount" => "nullable|numeric",
            "bill_payment_terms.*.payment_percent" => "numeric",
            "bill_payment_terms.*.payment_date" => "date",
        ];

        $rules += validateNullableField(request()->header("languages"), "main.notes", "string");
        $rules += validateNullableField(request()->header("languages"), "main.notes", "string");
        $rules += validateNullableField(request()->header("languages"),  "bills_items.*.item_desc", "string");
        $rules += validateNullableField(request()->header("languages"),  "bill_effects.*.remarks", "string");
        $rules += validateNullableField(request()->header("languages"), "bill_payment_terms.*.remarks", "string");
        $rules += validateNullableField(request()->header("languages"),  "bill_payment_terms.*.notes", "string");
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
