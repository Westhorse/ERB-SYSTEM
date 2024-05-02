<?php

namespace Modules\Warehouse\Http\Requests\Api\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class ItemsRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "inventory_ids" =>  "required|array",
            "inventory_ids.*" =>  "exists:w_inventories,id",
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
