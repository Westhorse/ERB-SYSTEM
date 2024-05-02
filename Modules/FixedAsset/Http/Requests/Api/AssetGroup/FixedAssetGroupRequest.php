<?php

namespace Modules\FixedAsset\Http\Requests\Api\AssetGroup;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;

//use App\Helpers\JsonResponse;

class   FixedAssetGroupRequest extends FormRequest
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
            'code' => checkCodeValidation(request()->method(), 'f_asset_groups', $this->asset_group->id ?? null)
        ];
        $rules += [
            'group_id'              => 'required|integer|exists:w_product_categories,id',
            'account_id'            => 'nullable|integer|exists:temp_accounts,id',
            'branch_id'             => 'nullable|integer|exists:c_branches,id',
            'relate_with'           => 'nullable|integer|between:0,5',
        ];
        $rules +=validateOneLangAsRequired(request()->header('languages'),request()->name, 'name');
        $rules +=validateNullableField(request()->header('languages'), 'notes' , 'string');
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




