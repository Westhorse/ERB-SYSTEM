<?php

namespace Modules\Warehouse\Http\Requests\Api\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProductTabulationRequest extends FormRequest
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
            "code" => checkCodeValidation(request()->method(), 'w_products_tabulation', $this->product_tabulation->id ?? null),
            "is_active"=>"nullable",
            "printer"=>"nullable",
            "productTabulationDetail" => "required|array",

            "productTabulationDetail.*.product_id"       => [
                'required',
                Rule::exists('w_products', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
        ];
//      dd($rules);
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');
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
