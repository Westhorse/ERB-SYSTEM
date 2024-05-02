<?php

namespace Modules\Common\Http\Controllers\Api\Area;

use Modules\Common\Transformers\Api\Area\RegionResource;
use Modules\Common\Repositories\IRepositories\Area\IRegionRepository;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Entities\Api\Area\Region;
use Modules\Common\Http\Requests\Api\Area\RegionRequest;
use App\Http\Resources;
use App\Http\Resources\NameResource;

class RegionController extends Controller
{

    public function __construct(private IRegionRepository $regionRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function index()
    {
        try {
            $regions = RegionResource::collection($this->regionRepository->all());
            return $regions->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function store(RegionRequest $request)
    {
        try {
            $model = $this->regionRepository->create($request->validated());
            $region = new RegionResource($model);
            return $region->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Region $region
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Region $region)
    {
        try {
            $region = new RegionResource($region);
            return $region->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->regionRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Region $region
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Region $region, RegionRequest $request)
    {
        try {
            $this->regionRepository->update($request->validated(), $region->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Region $region
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {

        try {
            $count = $this->regionRepository->deleteRecords('c_regions', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * navigation.
     *
     * @param Region $region , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Region $region)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $region = new RegionResource($this->regionRepository->navigate($region->id, $request->case));
            return $region->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->regionRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $regionsNames = NameResource::collection($this->regionRepository->names());
            return $regionsNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
