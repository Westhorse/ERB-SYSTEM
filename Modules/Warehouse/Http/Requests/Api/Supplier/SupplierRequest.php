<?php

namespace Modules\Warehouse\Http\Requests\Api\Supplier;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class SupplierRequest extends FormRequest
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

    public function rules(Request $request)
    {


        Log::debug($request->all());

        $rules = [
            'code' => checkCodeValidation(request()->method(), 'w_suppliers', $this->supplier ?? null),


            'telephone' => 'string|nullable',
            'fax_number' => 'string|nullable',
            'tax_number' => 'string|nullable',
            'is_active' => 'nullable|boolean',
            'account_id' => [
                'nullable',
                Rule::exists('temp_accounts', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
        ];
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
//    $rules += validateOneLangAsRequired(request()->header('languages'), request()->address, 'address');
//        $rules += validateOneLangAsRequired(request()->header('languages'), request()->address, 'address');

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
