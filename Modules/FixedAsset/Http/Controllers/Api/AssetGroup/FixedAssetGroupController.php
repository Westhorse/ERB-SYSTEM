<?php

namespace Modules\FixedAsset\Http\Controllers\Api\AssetGroup;

use Illuminate\Http\Request;

use App\Helpers\{
    JsonResponse
};
use App\Http\Controllers\Controller;
use Modules\FixedAsset\Entities\Api\AssetGroup\FixedAssetGroup;
use Modules\FixedAsset\Http\Requests\Api\AssetGroup\FixedAssetGroupRequest;
use Modules\FixedAsset\Repositories\IRepositories\IFixedAssetGroupRepository;
use Modules\FixedAsset\Transformers\Api\AssetGroup\FixedAssetGroupResource;

class FixedAssetGroupController extends Controller
{

    /**
     * @param IFixedAssetGroupRepository $fixedAssetGroupRepository
     */
    public function __construct(private IFixedAssetGroupRepository $fixedAssetGroupRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth developer
     */

    public function index()
    {
        try {
            $assetGroups = FixedAssetGroupResource::collection($this->fixedAssetGroupRepository->all());
            return $assetGroups->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth developer
     */
    public function store(FixedAssetGroupRequest $request)
    {
        try {
            $model = $this->fixedAssetGroupRepository->create($request->validated());
            $fixedAssetGroup = new FixedAssetGroupResource($model);
            return $fixedAssetGroup->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param FixedAssetGroup $fixedAssetGroup
     * @return \Illuminate\Http\Response
     * @auth developer
     */
    public function show(FixedAssetGroup $assetGroup)
    {
        try {
            $fixedAssetGroup = new FixedAssetGroupResource($assetGroup);
            return $fixedAssetGroup->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param FixedAssetGroup $fixedAssetGroup
     * @return \Illuminate\Http\Response
     * @auth developer
     */
    public function update(FixedAssetGroupRequest $request, FixedAssetGroup $assetGroup)
    {
        try {
            $validatedData = $request->validated();
            $this->fixedAssetGroupRepository->update($validatedData, $assetGroup->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FixedAssetGroup $fixedAssetGroup
     * @return \Illuminate\Http\Response
     * @auth developer
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->fixedAssetGroupRepository->deleteRecords('f_asset_groups', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->fixedAssetGroupRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, FixedAssetGroup $assetGroup)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $assetGroup = new FixedAssetGroupResource($this->fixedAssetGroupRepository->navigate($assetGroup->id, $request->case));
            return $assetGroup->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->fixedAssetGroupRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
