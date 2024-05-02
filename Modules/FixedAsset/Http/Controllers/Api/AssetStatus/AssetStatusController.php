<?php

namespace Modules\FixedAsset\Http\Controllers\Api\AssetStatus;

use Illuminate\Http\Request;
use App\Helpers\{
    JsonResponse,
};
use App\Http\Controllers\Controller;
use App\Http\Resources\NameResource;
use Modules\FixedAsset\Entities\Api\AssetStatus\AssetStatus;
use Modules\FixedAsset\Http\Requests\Api\AssetStatus\AssetStatusRequest;
use Modules\FixedAsset\Repositories\IRepositories\IAssetStatus\IAssetStatusRepository;
use Modules\FixedAsset\Transformers\Api\AssetStatus\AssetStatusResource;

class AssetStatusController extends Controller
{

    public function __construct(private IAssetStatusRepository $assetStatusRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function index()
    {
        try {
            $assetStatus = AssetStatusResource::collection($this->assetStatusRepository->all());
            return $assetStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function store(AssetStatusRequest $request)
    {
        try {
            $model = $this->assetStatusRepository->create($request->validated());
            $assetStatus = new AssetStatusResource($model);
            return $assetStatus->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(AssetStatus $assetStatus)
    {
        try {
            $assetStatus = new AssetStatusResource($assetStatus);
            return $assetStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function update(AssetStatusRequest $request, AssetStatus $assetStatus)
    {
        try {
            $validatedData = $request->validated();
            $this->assetStatusRepository->update($validatedData, $assetStatus->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->assetStatusRepository->deleteRecords('f_asset_status', $request['ids']);
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
            return JsonResponse::respondSuccess('success', $this->assetStatusRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * navigation.
     *
     * @param Example $example , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, AssetStatus $assetStatus)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $assetStatus = new AssetStatusResource($this->assetStatusRepository->navigate($assetStatus->id, $request->case));
            return $assetStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->assetStatusRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getNames()
    {
        try {
            $assetStatusNames = NameResource::collection($this->assetStatusRepository->names());
            return $assetStatusNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
