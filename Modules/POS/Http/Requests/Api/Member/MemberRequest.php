<?php

namespace Modules\POS\Http\Requests\Api\Member;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class MemberRequest extends FormRequest
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
            'code' => checkCodeValidation(request()->method(), 'pos_members', $this->member->id ?? null),
            'telephone' => 'string|nullable',
            'mobile' => 'string|nullable',
            'email' => 'string|email|nullable',
            'is_active' => 'nullable|boolean',
            'nationality_id' => [
                'nullable',
                Rule::exists('c_nationalities', 'id')->where(function ($query) {
                    $query->where('deleted_at', null);
                })
            ],
        ];

        $rules += validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
        $rules += validateNullableField(request()->header('languages'), 'work_field', 'string');
        $rules += validateNullableField(request()->header('languages'), 'address', 'string');
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
