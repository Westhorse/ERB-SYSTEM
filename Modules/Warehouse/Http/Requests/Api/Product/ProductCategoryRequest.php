<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class ProductCategoryRequest extends FormRequest
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
            'cost_way' => 'nullable|integer',
            'apply_tax' => 'nullable|integer',
            'product_type' => 'nullable|integer',
            'commission_type' => 'nullable|integer',
            'cash_commission' => 'nullable|integer',
            'later_commission' => 'nullable|integer',
            'purchase_disc_type' => 'nullable|integer',
            'purchase_disc_amount_type' => 'nullable|integer',
            'purchase_disc_amount' => 'nullable|integer',
            'cost_price_effect' => 'nullable|integer',
            'buy_free_percent' => 'nullable|integer',
            'sale_disc_type' => 'nullable|integer',
            'sale_disc_amount_type' => 'nullable|integer',
            'sale_disc_amount' => 'nullable|integer',
            'sale_free_percent' => 'nullable|integer',
            'is_active' => 'boolean',
            'code' => checkCodeValidation(request()->method(), 'w_product_categories', $this->product_category->id ?? null),
            // 'taxes' => 'sometimes',
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

        $rules +=validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
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
