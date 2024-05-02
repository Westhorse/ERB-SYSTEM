<?php

namespace Modules\Common\Http\Requests\Api\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VehicleDataRequest extends FormRequest
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

        $rules = [
            "code" => checkCodeValidation(request()->method(), 'c_vehicle_data', $this->vehicle_datum->id ?? null, 'vtype', request()->vtype),
            'vtype' => 'required',
            "model" => "nullable",
            "vehicle_kind" => "nullable",
            "base_size" => "nullable",
            "secret_no" => "nullable",
            "prod_country" => "nullable",
            "prod_date" => "nullable",
            "chassis_no" => "nullable",
            "color" => "nullable",
            "tank_cap1" => "nullable",
            "tank_cap2" => "nullable",
            "weight" => "nullable",
            "max_mnt_order" => "nullable",
            "allowed_ex_liter" => "nullable",
            "purchase_date" => "nullable",
            "purchase_price" => "nullable",
            "current_value" => "nullable",
            "renew_date" => "nullable",
            "vclass" => "nullable",
            "fuel_ratio" => "nullable",
            "oil_ratio" => "nullable",
            "base_type" => "nullable",
            "trans_license" => "nullable",
            "GPS_device" => "nullable",
            "ext_code" => "nullable",
            "is_active" => "nullable",
            "cards.*" => "nullable",
            "cards.*.start_date" => "nullable",
            "cards.*.end_date" => "nullable|after:cards.*.start_date",
            "vehicle_type_id" => "nullable"

        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->plate_number,'plate_number');
        $rules +=validateNullableField(request()->header('languages'),'notes','string');
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
