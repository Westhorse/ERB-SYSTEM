<?php

namespace Modules\Common\Http\Requests\Api\Card;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DocumentTypeRequest extends FormRequest
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
        $rules =[

            "code" =>checkCodeValidation(request()->method(), 'c_document_types', $this->document_type->id ?? null, 'dtype', request()->dtype),
            "dtype" => "nullable",
            "follow_renewal" => "nullable",
            "days_count" => "nullable",
            "is_active" => "nullable",

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
