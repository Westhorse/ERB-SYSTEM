<?php

namespace Modules\Common\Http\Controllers\Api\Localization;


use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Entities\Api\Localization\District;
use Modules\Common\Http\Requests\Api\Localization\DistrictRequest;
use Modules\Common\Repositories\IRepositories\Localization\IDistrictRepository;
use Modules\Common\Transformers\Api\Localization\DistrictResource;
use App\Http\Resources;

class DistrictController extends Controller
{

    public function __construct(private IDistrictRepository $districtRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function index()
    {
        try {
            $districts = DistrictResource::collection($this->districtRepository->all());
            return $districts->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function store(DistrictRequest $request)
    {
        try {
            $model = $this->districtRepository->create($request->validated());
            $district = new DistrictResource($model);
            return $district->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param District $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function show(District $district)
    {
        try {
            $district = new DistrictResource($district);
            return $district->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Example $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function update(District $district, DistrictRequest $request)
    {
        try {
            $this->districtRepository->update($request->validated(), $district->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Example $district
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->districtRepository->deleteRecords('c_districts', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * navigation.
     *
     * @param District $district , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, District $district)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $district = new DistrictResource($this->districtRepository->navigate($district->id, $request->case));
            return $district->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    
    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->districtRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $districtsNames = NameResource::collection($this->districtRepository->names());
            return $districtsNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->districtRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
