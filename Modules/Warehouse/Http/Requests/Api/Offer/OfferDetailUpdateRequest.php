<?php

namespace Modules\Warehouse\Http\Requests\Api\Offer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class OfferDetailUpdateRequest extends FormRequest
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
            'kind' => 'required',
            'required_qty' => 'required',
            'offer_qrt' => 'required',
            'max_offer_qty' => 'required',
            'item_price' => 'required',
            'discount_percent' => 'required',
            'free_qty' => 'required',
            'warehouse_id' => [
                'nullable',
                Rule::exists('w_warehouses', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'offer_id' => [
                'nullable',
                Rule::exists('w_offers', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'product_id' => [
                'nullable',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
        ];

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
