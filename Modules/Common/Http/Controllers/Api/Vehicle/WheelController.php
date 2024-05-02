<?php

namespace Modules\Common\Http\Controllers\Api\Vehicle;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Vehicle\WheelResource;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Vehicle\Wheel;
use Modules\Common\Http\Requests\Api\Vehicle\WheelRequest;
use Modules\Common\Repositories\IRepositories\Vehicle\IWheelRepository;

class WheelController extends Controller
{

    public function __construct(private IWheelRepository $wheelRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function index(Request $request)
    {
        try {
            $wheels = WheelResource::collection($this->wheelRepository->getAllByType($request->vtype));
            return $wheels->additional(JsonResponse::success());
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
    public function store(WheelRequest $request)
    {
        try {
            $model = $this->wheelRepository->create($request->validated());
            $wheel = new WheelResource($model);
            return $wheel->additional(JsonResponse::savedSuccessfully());
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
    public function show(Wheel $wheelType)
    {
        try {
            $wheelType = new WheelResource($wheelType);
            return $wheelType->additional(JsonResponse::success());
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
    public function update(WheelRequest $request, Wheel $wheelType)
    {
        try {
            $this->wheelRepository->update($request->validated(), $wheelType->id);
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
            $count = $this->wheelRepository->deleteRecords('c_wheels', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, Wheel $wheelType)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $wheelType = new WheelResource($this->wheelRepository->navigate($wheelType->id, $request->case, 'vtype', $request->vtype));
            return $wheelType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {

        try {
            return JsonResponse::respondSuccess('success', $this->wheelRepository->codeGenerator('vtype', $request['vtype']));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->wheelRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
