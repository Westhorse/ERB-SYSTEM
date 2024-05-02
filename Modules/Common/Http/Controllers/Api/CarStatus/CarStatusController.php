<?php

namespace Modules\Common\Http\Controllers\Api\CarStatus;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\CarStatus\CarStatusResource;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\CarStatus\CarStatus;
use Modules\Common\Http\Requests\Api\CarStatus\CarStatusRequest;
use Modules\Common\Repositories\IRepositories\ICarStatusRepository;

use function trans;

class CarStatusController extends Controller
{

    public function __construct(private ICarStatusRepository $carStatusRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $carStatus = CarStatusResource::collection($this->carStatusRepository->all());
            return $carStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarStatusRequest $request)
    {
        try {
            $model = $this->carStatusRepository->create($request->all());
            $example = new CarStatusResource($model);
            return $example->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(CarStatus $carStatus)
    {
        try {
            $carStatus = new CarStatusResource($carStatus);
            return $carStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CarStatusRequest $request, CarStatus $carStatus)
    {
        try {
            $this->carStatusRepository->update($request->all(), $carStatus->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->carStatusRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $count = $this->carStatusRepository->deleteRecords('c_car_status', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, CarStatus $carStatus)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $carStatus = new CarStatusResource($this->carStatusRepository->navigate($carStatus->id, $request->case, 'type', $request->type));
            return $carStatus->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->carStatusRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
