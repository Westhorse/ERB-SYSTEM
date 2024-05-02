<?php

namespace Modules\Common\Http\Requests\Api\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WheelRequest extends FormRequest
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
        if (request()->method() == 'PATCH'){
            $code = ['required', Rule::unique('c_wheels','code')->ignore($this->wheel_type)];
            }else {
            $code = ['string','required',Rule::unique('c_wheels')->where(function ($query) {
             $query->where('vtype',request()->vtype);
             $query->where('deleted_at',null);
         })];

            }
         $rules= [
       'code' => checkCodeValidation(request()->method(), 'c_wheels', $this->wheel_type->id ?? null, 'vtype', request()->vtype),
             'vtype'                     => 'required|in:1,2',
             'is_active'                  => 'nullable|boolean',
         ];
         $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name,'name');

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
