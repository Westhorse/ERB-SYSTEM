<?php

namespace Modules\Common\Http\Requests\Api\Translations;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class MessageRequest extends FormRequest
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

        $rules = [];
        if (request()->method() == 'PATCH' || request()->method() == 'PUT') {
            $key = ['string', Rule::unique('c_messages', 'key')->where(function ($query) {
                $query->where('code', request()->code)->where('deleted_at', null);
            })->ignore($this->message['id'])];
        } else {
            $key = [
                'string',
                Rule::unique('c_messages', 'key')->where(function ($query) {
                    $query->where('code', request()->code)->where('deleted_at', null);
                })
            ];
        }
        $rules += validateOneLangAsRequired(request()->header('languages'), request()->value, 'value');
        $rules += [
            'code' => 'string',
            'key' => $key,
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
