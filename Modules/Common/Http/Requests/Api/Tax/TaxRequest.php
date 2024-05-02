<?php

namespace Modules\Common\Http\Requests\Api\Tax;

use App\Rules\CustomTaxArray;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TaxRequest extends FormRequest
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


        if (request()->method() == 'PATCH') {
            $code = ['required', Rule::unique('c_taxes','code')->ignore($this->tax->id)];
        } else {
            $code = ['required', Rule::unique('c_taxes')->where(function ($query) {
                $query->where('deleted_at',null);
            })];
        }
        $rules= [
          'code' => checkCodeValidation(request()->method(), 'c_taxes', $this->tax->id ?? null),
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
