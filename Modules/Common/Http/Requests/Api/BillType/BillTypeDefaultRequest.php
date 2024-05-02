<?php

namespace Modules\Common\Http\Requests\Api\BillType;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class BillTypeDefaultRequest extends FormRequest
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
            "cost_center_id" => [
                "nullable",
                Rule::exists("temp_cost_centers", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "employee_id" => [
                "nullable",
                Rule::exists("temp_employees", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "project_id" => 'required',
            "discount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "opposite_discount_account_id" => [
                "nullable",
                Rule::exists("temp_accounts", "id")->where(function ($query) {
                    $query->where("is_active", 1)->where("deleted_at", null);
                })
            ],
            "reference_id" => "required",
            "warehouse_id" => "required",
            "pos_id" => "required",
            "payment_type" => "required",
            "default_price" => "required",
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
    }}
