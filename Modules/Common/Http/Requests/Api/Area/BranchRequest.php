<?php

namespace Modules\Common\Http\Requests\Api\Area;

use Illuminate\Validation\Rule;
use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class BranchRequest extends FormRequest
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
            "code" => checkCodeValidation(request()->method(), 'c_branches', $this->branch->id ?? null),
            "is_active" => "nullable|boolean",
            'business' => "required|array",
            'business.*' =>                 
                Rule::exists('c_business', 'id')->where(function ($query) {
                $query->where('deleted_at', null)->where('is_active', true);
            }),

            'region_id' => [
                'required',
                Rule::exists('c_regions', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', true);
                })
            ],
            
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
