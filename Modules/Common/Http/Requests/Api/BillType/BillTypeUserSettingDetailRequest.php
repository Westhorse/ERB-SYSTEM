<?php

namespace Modules\Common\Http\Requests\Api\BillType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class BillTypeUserSettingDetailRequest extends FormRequest
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
    public function rules( )
    {
        $rules = [
            "bill_type_default_id" => [
                "nullable",
                Rule::exists("c_bill_types_defaults", "id")
            ],
            "account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "opposite_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "payment_type" => "required",
        ];

        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->label,'label');
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
    }}
