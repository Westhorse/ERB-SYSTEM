<?php

namespace Modules\Common\Http\Requests\Api\BillType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class BillTypeRequest extends FormRequest
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
        $rules = [];
        // $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules += validateNullableField(request()->header("languages"), "name", "string");

        $rules += [
            "branch_id" => [
                "nullable",
                Rule::exists("c_branches", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "group_id" => [
                "required",
                Rule::exists("c_bill_types_groups", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "type_id" => "required",
            "payment_voucher_id" => "nullable",
            "currency_id" => [
                "nullable",
                Rule::exists("c_currencies", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "accumulated_bill_type_id" => "nullable",
            "change_bill_type_id" => "nullable",
            "offer_id" =>  [
                "nullable",
                Rule::exists("w_offers", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "transfer_warehouse_id" => "nullable",
            "in_bill_type_id" => [
                "nullable",
                Rule::exists("c_bill_types", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "out_bill_type_id" => [
                "nullable",
                Rule::exists("c_bill_types", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "transfer_branch_id" => [
                "nullable",
                Rule::exists("c_branches", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "cost_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "stock_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "donate_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "discount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "add_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "paid_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "rest_amount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            // خصائص أساسية
            "stocking_effect" => "nullable",
            "cost_price_effect" => "nullable",
            "discount_cost_price_effect" => "nullable",
            "add_cost_price_effect" => "nullable",
            "distribution_type" => "nullable",
            "accounting_effect" => "nullable",
            "automatic_accounting_posting" => "nullable",
            "bill_section" => "nullable",
            "compound_Journal" => "nullable",
            "sum_debit_acc" => "nullable",
            "sum_credit_acc" => "nullable",
            "load_generated_journal" => "nullable",
            "exchange_expenses_income_acc" => "nullable",
            "exchange_product_stock_acc" => "nullable",
            "post_bill_cost" => "nullable",
            "account_balance" => "nullable",
            "automatic_save_bill" => "nullable",
            "allow_selling_non_entry_serial" => "nullable",
            "random_serials" => "nullable",
            "ignore_product_add_discount" => "nullable",
            "cost_center_mandatory" => "nullable",
            "representative_mandatory" => "nullable",
            "multi_version" => "nullable",
            "code_per_user" => "nullable",
            //خيارات إضافية
            "time_limit" => "nullable",
            "cost_center_type" => "nullable",
            "qty_approximation_digits" => "nullable",
            "amount_approximation_digits" => "nullable",
            "barcode_search" => "nullable",
            "output_oldest_expire_date" => "nullable",
            "output_expire_date_purchase_date" => "nullable",
            "expire_date_purchase_discount" => "nullable",
            "edit_item_qty" => "nullable",
            "update_query" => "nullable",
            "product_category_filter" => "nullable",
            "contact_filter_by_company" => "nullable",
            "use_smpile_bill" => "nullable",
            "calculate_compound_price" => "nullable",
            "consider_payment_value_in_Bill_paid" => "nullable",
            "use_price_from_last_offer" => "nullable",
            "use_price_list" => "nullable",
            "discount_qty_as_percent" => "nullable",
            "add_qty_as_percent" => "nullable",
            "payment_terms_with_net_invoice" => "nullable",
            "open_drawer_with_add" => "nullable",
            "pirce_modification_with_total_modification" => "nullable",
            "connect_with_customs_transaction" => "nullable",
            "max_item_qty" => "nullable",
            "company_filter_acc" => "nullable",
            "use_touch_screen" => "nullable",
            "connect_with_employee_vehicle" => "nullable",
            "modify_vehicle_weight" => "nullable",
            "use_default_warehouse" => "nullable",
            "generate_voucher_to_warehouse" => "nullable",
            "normal_price_color" => "nullable",
            "min_cost_price_color" => "nullable",
            "min_sell_price_color" => "nullable",
            "negative_qty_color" => "nullable",
            "exceed_min_limit_color" => "nullable",
            "exceed_max_limit_color" => "nullable",
            "exceed_zero_qty_color" => "nullable",
            "price_from_offers_color" => "nullable",
            //الضريبة
            "tax_exemption" => "nullable",
            "manual_tax_entry" => "nullable",
            "tax_base" => "nullable",
            //فاتورة المناقلة
            "generate_transfer_bill" => "nullable",
            "show_transfer_bill" => "nullable",
            "transfer_price" => "nullable",
            //المراجع
            "hide_closed_ref" => "nullable",
            "confirm_ref" => "nullable",
            "default_ref" => "nullable",
            "choose_customer_before_ref" => "nullable",
            "delete_bill_ref" => "nullable",
            "update_prices_from_bill_prices" => "nullable",
            "add_to_exist_items" => "nullable",
            "hide_services_items" => "nullable",
            "automatic_load_items" => "nullable",
            "apply_ref_discount" => "nullable",
            "apply_ref_qty_discount" => "nullable",
            "show_ref_of_ref" => "nullable",
            "show_ref_number" => "nullable",
            "choose_multi_ref" => "nullable",
            "save_ref_number" => "nullable",
            "add_ref_info" => "nullable",
            "update_expire_date" => "nullable",
            "get_bill_ref" => "nullable",
            "get_remakrs" => "nullable",
            "get_payment_conditions" => "nullable",
            "get_table_warehouse" => "nullable",
            "get_add_discount" => "nullable",
            "get_ref_voucher" => "nullable",
            "get_voucher_values_without_tax" => "nullable",
            "get_cost_centers" => "nullable",
            "get_main_warehouse" => "nullable",
            "get_payment_way" => "nullable",
            "get_ref_branch" => "nullable",
            "get_table_remarks" => "nullable",
            "get_account" => "nullable",
            "get_bill_ref_number" => "nullable",
            "get_time_limit" => "nullable",
            "search_in_ref_items" => "nullable",
            "search_in_opened_ref_items" => "nullable",
            "get_additional_data" => "nullable",
            "get_additional_fields" => "nullable",
            "recalculate_tax" => "nullable",
            "determinants_replacement" => "nullable",
            "taxes" => "array",
            "taxes.*" =>
            Rule::exists("c_taxes", "id")->where(function ($query) {
                $query->where("deleted_at", null);
            }),
            "billTypeUser" => "array",
            "billTypeUser.*.id" => "nullable",
            "billTypeUser.*.user_id" => "nullable",
            "billTypeUser.*.warehouse_id" => "nullable",
            "billTypeUser.*.employee_id" => "nullable",
            "billTypeUser.*.cost_center_id" => "nullable",
            "billTypeUser.*.payment_type" => "nullable",
            "billTypeUser.*.reference_id" => "nullable",
            "billTypeUser.*.default_price" => "nullable",
            "billTypeUser.*.project_id" => "nullable",
            "billTypeUser.*.discount_account_id" => "nullable",
            "billTypeUser.*.opposite_discount_account_id" => "nullable",
            "billTypeUser.*.pos_id" => "nullable",
            "billTypeUser.*.billTypeUserDetail" => "array",
            "billTypeUser.*.billTypeUserDetail.*.id" => "nullable",
            "billTypeUser.*.billTypeUserDetail.*.account_id" => "nullable",
            "billTypeUser.*.billTypeUserDetail.*.opposite_account_id" => "nullable",
            "billTypeUser.*.billTypeUserDetail.*.payment_type" => "nullable",

            "billTypeDefault.cost_center_id" =>  [
                "nullable",
                Rule::exists("temp_cost_centers", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.employee_id" =>  [
                "nullable",
                Rule::exists("temp_employees", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.project_id" => [
                "nullable",
                Rule::exists("temp_projects", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.discount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.opposite_discount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.warehouse_id" =>  [
                "nullable",
                Rule::exists("w_warehouses", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "billTypeDefault.pos_id" =>  [
                "nullable",
                Rule::exists("pos_cashiers", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "billTypeDefault.payment_type" => "in:1,2,3",
            "billTypeDefault.default_price" => "numeric",
            "billTypeDefault.billTypeDefaultDetail.*.id" => [
                "nullable",
                Rule::exists("c_bill_types_defaults_details", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.billTypeDefaultDetail.*.account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.billTypeDefaultDetail.*.opposite_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("deleted_at", null);
                })
            ],
            "billTypeDefault.billTypeDefaultDetail.*.payment_type" => "in:0,1,2,3",
        ];

        $rules += validateNullableField(request()->header("languages"), "billTypeDefault.billTypeDefaultDetail.*.label", "string");
        $rules += validateNullableField(request()->header("languages"), "billTypeUser.*.billTypeUserDetail.*.label", "string");
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
