<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class ProductCategoryUpdateRequest extends FormRequest
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
            'cost_way' => 'required|integer',
            'apply_tax' => 'required|integer',
            'product_type' => 'required|integer',
            'cash_commission' => 'required',
            'later_commission' => 'required',
            'commission_type' => 'required|integer',
            'purchase_disc_type' => 'required|integer',
            'purchase_disc_amount_type' => 'required|integer',
            'purchase_disc_amount' => 'required',
            'cost_price_effect' => 'required',
            'buy_free_percent' => 'required',
            'sale_disc_type' => 'required|integer',
            'sale_disc_amount_type' => 'required|integer',
            'sale_disc_amount' => 'required',
            'sale_free_percent' => 'required',
            'is_active' => 'nullable|boolean',
            'taxable' => 'boolean',
            'code' => checkCodeValidation(request()->method(), 'w_product_categories', $this->productCategory->id ?? null),
            'parent_id' => [
                'nullable',
                Rule::exists('w_product_categories', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'branch_id' => [
                'nullable',
                Rule::exists('c_branches', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'unit_id' => [
                'nullable',
                Rule::exists('w_units', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'sales_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'resales_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'purchase_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'repurchase_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'cost_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'stock_account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
        ];

        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');
        $rules +=validateNullableField(request()->header('languages'), 'notes' , 'string');

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
