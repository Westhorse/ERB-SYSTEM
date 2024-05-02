<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class PriceListRequest extends FormRequest
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


            "code" => checkCodeValidation(request()->method(), 'w_price_lists', $this->price_list->id ?? null),
            "is_active"=>"nullable",
            "start_date"=>"nullable|date",
            "end_date"=>"nullable|date|after:start_date",
            "priceListsDetail"    => "required|array",

            "priceListsDetail.*.product_id"       => [
                'required',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "priceListsDetail.*.unit_id"       => [
                'required',
                Rule::exists('w_units', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "priceListsDetail.*.price"       => "required",

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
