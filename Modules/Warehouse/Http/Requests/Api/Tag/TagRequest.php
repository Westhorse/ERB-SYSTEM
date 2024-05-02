<?php

namespace Modules\Warehouse\Http\Requests\Api\Tag;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

class TagRequest extends FormRequest
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
            'is_active' => ['boolean'],
            'code' => checkCodeValidation(request()->method(), 'w_tags', $this->tag->id ?? null)
        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'), request()->name, 'name');
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
