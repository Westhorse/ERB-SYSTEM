<?php

namespace Modules\POS\Http\Requests\Api\Cashier;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;


use function request;

class CashierRequest extends FormRequest
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

    // function getExcept($collection, $exception, $attributeName) {
    //     return $collection->map(function ($item) use ($exception, $attributeName) {
    //         if ($item != $exception) {
    //             return $attributeName.'.'.$item.',';
    //         }
    //     })->implode('');
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'code' => checkCodeValidation(request()->method(), 'pos_cashiers', $this->cashier->id ?? null),
            'is_active' => 'nullable|boolean',
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
