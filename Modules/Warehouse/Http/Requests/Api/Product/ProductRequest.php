<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'code'=> checkCodeValidation(request()->method(), 'w_products', $this->product->id ?? null),
            'unit_id'       => [
                'required',
                Rule::exists('w_units', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'category_id'       => [
                'required',
                Rule::exists('w_product_categories', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'guarantee_id'       => [
                'nullable',
                Rule::exists('w_guarantee', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'sales_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'resales_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'purchase_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'repurchase_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'cost_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'stock_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],

            'product_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],

            'deprecation_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],

            'total_deprecation_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],


            'asset_status_id'       => [
                'nullable',
                Rule::exists('f_asset_status', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'car_id'       => [
                'nullable',
                Rule::exists('c_vehicle_data', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'trailer_id'       => [
                'nullable',
                Rule::exists('c_vehicle_data', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],




            "barcode" => "nullable|string",
            "cash_commission" => "nullable|numeric",
            "cost_way" => "nullable|numeric",
            "later_commission" => "nullable|numeric",
            "commission_type" => "nullable|numeric",
            "max_stock" => "nullable|numeric",
            "min_stock" => "nullable|numeric",
            "order_limit" => "nullable|numeric",
            "product_type" => "nullable|numeric",

            "asset_value" => "nullable|numeric",
            "deprecation_percent" => "nullable|numeric",
            "purchase_value" => "nullable|numeric",
            "deprecation_amount" => "nullable|numeric",
            "scrap_amount" => "nullable|numeric",
            "apply_deprecation" => "nullable|boolean",
            "deprecation_start_date" => "nullable|date",
            "purchase_date" => "nullable|date",


            "is_active" => "nullable|boolean",

            "default_qty" => "nullable|numeric",
            "initial_cost_price" => "nullable|numeric",
            "cost_price" => "nullable|numeric",
            "sales_price" => "nullable|numeric",
            "min_sales_price" => "nullable|numeric",
            "weight" => "nullable|numeric",
            "transportation_fees" => "nullable|numeric",
            "purchase_disc_type" => "nullable|numeric",
            "purchase_disc_amount_type" => "nullable|numeric",
            "purchase_disc_amount" => "nullable|numeric",
            "sale_disc_type" => "nullable|numeric",
            "sale_disc_amount_type" => "nullable|numeric",
            "sale_disc_amount" => "nullable|numeric",
            "sale_free_percent" => "nullable|numeric",
            "max_sales_disc_amount" => "nullable|numeric",
            "life_time" => "nullable|numeric",
            "life_time_type" => "nullable|numeric",
            "is_diff_weight_mat" => "nullable|numeric",
            "has_nofraction" => "nullable|numeric",
            "guarantee_days" => "nullable|numeric",
            "product_kind" => "nullable|numeric",
            "lengh_factor" => "nullable|numeric",
            "width_factor" => "nullable|numeric",
            "height_factor" => "nullable|numeric",
            "scales_material" => "nullable|numeric",
            "scales_part1" => "nullable|numeric",
            "scales_part2" => "nullable|numeric",
            "scales_part3" => "nullable|numeric",

            "suppliers" => "nullable|array",
            "suppliers.*.supplier_id"      => [
                'nullable',
                Rule::exists('w_suppliers', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],


            "determinants" => "nullable|array",
            "determinants.*.determinant_id"      => [
                'nullable',
                Rule::exists('w_determinants', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "determinants.*.in_product_balanct" => "nullable",
            "determinants.*.in_product_qty" => "nullable",

            "taxes" => "nullable|array",
            "taxes.*.tax_id" =>  [
                'nullable',
                Rule::exists('c_taxes', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],


            "tags" => "nullable|array",

            "tags.*.tag_id" => [
                'nullable',
                Rule::exists('w_tags', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],


            "compounds" => "nullable|array",
            'compounds.*.src_product_id'       => [
                'nullable',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "compounds.*.product_qty" => "nullable|string",
            "compounds.*.cost_price" => "nullable|string",
            "compounds.*.sell_price" => "nullable|string",


            "units" => "nullable|array",
            "units.*.unit_id"       => [
                'nullable',
                Rule::exists('w_units', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "units.*.convert_rate" => "nullable|numeric",
            "units.*.sales_price" => "nullable|numeric",
            "units.*.min_sales_price" => "nullable|numeric",
            "units.*.weight" => "nullable|numeric",
            "units.*.barcode" => "nullable",


            "alternatives" => "nullable|array",
            "alternatives.*.alternative_type" => "nullable|numeric",
            'alternatives.*.alternate_product_id'       => [
                'nullable',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],

            "warehouses" => "nullable|array",
            'warehouses.*.warehouse_id'       => [
                'nullable',
                Rule::exists('w_warehouses', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "warehouses.*.item_location" => "nullable",
            "warehouses.*.min_level" => "nullable",
            "warehouses.*.max_level" => "nullable",
            "warehouses.*.reload_level" => "nullable",

        ];
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules +=validateNullableField(request()->header('languages'), 'description' , 'string');

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
