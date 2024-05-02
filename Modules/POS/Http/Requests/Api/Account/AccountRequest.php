<?php

namespace Modules\POS\Http\Requests\Api\Account;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

use function request;

class AccountRequest extends FormRequest
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
            $code = 'required|unique:temp_accounts,code,' . $this->account->id;
        } else {
            $code = ['required', Rule::unique('temp_accounts')];
        }

        $rules = [
            'code' => $code,
            "name_ar" => "string|required_if:name_en,null",
            "name_en" => "string|nullable",
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
