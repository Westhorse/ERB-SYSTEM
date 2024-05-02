<?php

namespace Modules\Common\Http\Requests\Api\Area;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class RegionRequest extends FormRequest
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
            'currency_id' => [
                'required',
                Rule::exists('c_currencies', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', true);
                })
            ],
            'time_zone_id' => [
                'required',
                Rule::exists('c_time_zone', 'id')->where(function ($query) {
                    $query->where('deleted_at', null)->where('is_active', true);
                })
            ],
            'is_active' => ['boolean'],
            'code' => checkCodeValidation(request()->method(), 'c_regions', $this->region->id ?? null)
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
