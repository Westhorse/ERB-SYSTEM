<?php

namespace Modules\Common\Http\Requests\Api\Currency;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CurrencyRequest extends FormRequest
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
        if (request()->method() == 'PATCH') {
            $code = ['required', Rule::unique('c_currencies', 'code')->ignore($this->currency->id)];
        } else {
            $code = ['required', Rule::unique('c_currencies')->where(function ($query) {
                $query->where('deleted_at', null);
            })];
        }

        $rules = [
            'code' => checkCodeValidation(request()->method(), 'c_currencies', $this->currency->id ?? null),
            "is_active"    => "nullable|boolean",
            "symbol"    => "nullable",
            "parts"    => "nullable|array",
            "parts.*.rate"       => "nullable",
            "parts.*.is_active"       => "nullable",

            "exchanges"    => "nullable|array",
            "exchanges.*.exchange_rate"    => "nullable",
            "exchanges.*.to_currency_id" =>  [
                'nullable',
                Rule::exists('c_currencies_exchange', 'id')->where(function ($query) {
                    $query->where('is_active', 1)->where('deleted_at', null);
                })
            ],
            "exchanges.*.exchange_date"    => "nullable|date",
        ];

        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules +=validateNullableField(request()->header('languages'), 'part_name' , 'string');

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
