<?php

namespace Modules\FixedAsset\Http\Requests\Api\AssetTransfer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class AssetStatusRequest extends FormRequest
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
    public function rules( )
    {
        $rules = [
            'is_active' => "nullable|boolean",
            'product_id'       => [
                'required',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'user_id'       => [
                'required',
                Rule::exists('temp_users', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'current_status_id'       => [
                'nullable',
                Rule::exists('f_asset_status', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'current_cost_center_id'       => [
                'nullable',
                Rule::exists('temp_cost_centers', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'current_deprecation_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'old_status_id'       => [
                'nullable', 
                Rule::exists('f_asset_status', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'old_cost_center_id'       => [
                'nullable',
                Rule::exists('temp_cost_centers', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],
            'old_deprecation_account_id'       => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'order_date'=>"required|date",
            'order_number' => checkNumperValidation(request()->method(), 'f_asset_transfer', $this->asset_transfer->id ?? null)
        ];
        $rules +=validateNullableField(request()->header('languages'), 'remarks' , 'string');
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
