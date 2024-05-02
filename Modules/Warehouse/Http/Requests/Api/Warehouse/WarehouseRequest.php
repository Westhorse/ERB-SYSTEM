<?php

namespace Modules\Warehouse\Http\Requests\Api\Warehouse;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;
use  Modules\Warehouse\Entities\Api\Warehouse\Warehouse;

class WarehouseRequest extends FormRequest
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

        if ($this->isMethod('patch') && request()->id !== null) {
            $childs =   implode(',', Warehouse::findOrFail(request()->id)->childsIDs()->toArray());
        }
        $rules = [
            'code' => checkCodeValidation(request()->method(), 'w_warehouses', $this->warehouse->id ?? null),
            'district_id' => [
                'nullable',
                Rule::exists('c_districts', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],

            'branches_business_id'         => [
                'nullable',
                Rule::exists('c_branches_business', 'id')
            ],


            'warehouse_keeper_id'       => [
                'nullable',
                Rule::exists('temp_employees', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ],

            'parent_id'         => $this->isMethod('POST') ? [
                'numeric', 'nullable',
                Rule::exists('w_warehouses', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', 1);
                })
            ] : ["nullable", Rule::exists('w_warehouses', 'id')->where(function ($query) {
                $query->where('deleted_at', null)->where('is_active', 1);
            }),],
            'is_active' => 'nullable|boolean',

            'driver_id' => [
                'nullable',
                Rule::exists('temp_employees', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
            'in_bill_type_id'     => 'nullable|exists:w_invoice_types,id',
            'out_bill_type_id'    => 'nullable|exists:w_invoice_types,id',
            "address_map" => "nullable",
            'lat' => 'nullable',
            'long' => 'nullable',
            'fp_account_id' => 'nullable|exists:temp_accounts,id',
            'lp_account_id' => 'nullable|exists:temp_accounts,id',

            "effect_in_store_value" => 'nullable|boolean',
            "warehouse_keeper" => "nullable|string",
            "is_active" => 'nullable|boolean'
        ];
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules += validateNullableField(request()->header('languages'), 'address', 'string');
        $rules += validateNullableField(request()->header('languages'), 'notes', 'string');



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
