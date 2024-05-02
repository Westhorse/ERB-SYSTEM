<?php

namespace Modules\POS\Http\Requests\Api\PointSection;

use App\Models\PointSection\PointSection;
use App\Rules\FromIntersectRule;
use App\Rules\ToIntersectRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class PointSectionStoreRequest extends FormRequest
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
        foreach (request()->value as $key => $request_first) {
            $startSection = $request_first['section_from'];
            $endSection = $request_first['section_to'];
            if ($endSection > $startSection) {
            foreach (request()->value as $key_2 => $request_secound) {
                if ($request_first['section_from'] != $request_secound['section_from'] ||
                        $request_first['section_to'] != $request_secound['section_to']) {
                            $check_from=in_array($request_secound['section_from'], range($startSection, $endSection));
                        if ($check_from) {
                            $rules += ["value." . $key_2 . ".section_from" => "gt:" . $request_first['section_to']];
                        }
                        $check_to = in_array($request_secound['section_to'], range($startSection, $endSection));
                        if ($check_to) {
                            $rules += ["value." . $key_2 . ".section_to" => "gt:" . $request_first['section_to']];
                        }
                    }
            }
        }
        }
        $rules += [
           // "value.*.id" => ["nullable"],
            "value.*.section_from" => ["required"],
            "value.*.section_to" => ["required"],
            "value.*.point_value" => 'required',
            // "value.*.point_value" => "required|gt:5"
        ];
        // dd($rules);

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
