<?php

namespace Modules\Warehouse\Http\Requests\Api\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;


class InventoryRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "code" => checkCodeValidation(request()->method(), "w_inventories", $this->inventory->id ?? null),
            "inventory_date" => "required|date",
            "itemsChanged" => "boolean",
            "warehouse_id" =>  "required|exists:w_warehouses,id",
            "currency_id" =>  "required|exists:c_currencies,id",
            "conversion_factor" => "required|numeric",
            "inventory_type" => "required|in:1,2",
            "is_approved" => "boolean",

            'list' => [
                'array',
                request('inventory_type') == 2 ?  "required" : "nullable"
            ],
            "list.*" => "exists:w_inventories,id",

            "items" => "required|array",
            "items.*.product_id" => "required|exists:w_products,id",
            "items.*.product_qty" => "required|numeric",
        ];
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');

        $rules += validateNullableField(request()->header("languages"), "remarks", "string");
        $rules += validateNullableField(request()->header("languages"), "items.*.remarks", "string");

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
