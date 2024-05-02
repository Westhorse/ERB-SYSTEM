<?php

namespace Modules\Warehouse\Http\Requests\Api\Offer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

use function request;

class OfferStoreRequest extends FormRequest
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
            "code" => checkCodeValidation(request()->method(), 'w_offers', $this->offer->id ?? null),
            "from_date" => ["required", "before:to_date"],
            "to_date" => ["required", "after:from_date"],
            'warehouse_id' => [
                'nullable',
                Rule::exists('w_warehouses', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            'is_active' => 'boolean',


            "offerDetails"    => "required|array",

            "offerDetails.*.product_id"       => [
                'required',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "offerDetails.*.unit_id"       => [
                'nullable',
                Rule::exists('w_units', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "offerDetails.*.warehouse_id"       => [
                'nullable',
                Rule::exists('w_warehouses', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "offerDetails.*.required_qty"        => "numeric|min:0|not_in:0",
            "offerDetails.*.offer_qrt"           => "numeric|min:0|not_in:0",
            "offerDetails.*.max_offer_qty"       => "numeric|min:0|not_in:0",
            "offerDetails.*.item_price"          => "numeric|min:0|not_in:0",
            "offerDetails.*.free_qty"            => "numeric|min:0|not_in:0",
            "offerDetails.*.discount_percent"    => "numeric|min:0|not_in:0",

        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');

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
