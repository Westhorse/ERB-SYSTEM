<?php

namespace Modules\Common\Http\Controllers\Api\CarClassification;

use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Entities\Api\CarClassification\CarClassification;
use Modules\Common\Http\Requests\Api\CarClassification\CarClassificationRequest;
use Modules\Common\Repositories\IRepositories\ICarClassificationRepository;
use Modules\Common\Transformers\Api\CarClassification\CarClassificationResource;
use App\Http\Resources;
use App\Http\Resources\NameResource;

use function trans;

class CarClassificationController extends Controller
{

    public function __construct(private ICarClassificationRepository $carClassificationRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Nesma
     */
    public function index()
    {
        try {
            $carClassifications = CarClassificationResource::collection($this->carClassificationRepository->all());
            return $carClassifications->additional(JsonResponse::success());
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
    public function store(CarClassificationRequest $request)
    {
        try {
            $model = $this->carClassificationRepository->create($request->validated());
            $carClassification = new CarClassificationResource($model);
            return $carClassification->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param CarClassification $CarClassification
     * @return \Illuminate\Http\Response
     * @auth Nesma
     */
    public function show(CarClassification $carClassification)
    {
        try {
            $carClassification = new CarClassificationResource($carClassification);
            return $carClassification->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param CarClassification $CarClassification
     * @return \Illuminate\Http\Response
     * @auth Nesma
     */
    public function update(CarClassificationRequest $request, CarClassification $carClassification)
    {
        try {
            $this->carClassificationRepository->update($request->validated(), $carClassification->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param CarClassification $CarClassification
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function destroy(Request $request)
    {

        try {
            $count = $this->carClassificationRepository->deleteRecords('c_vehicle_classifications', $request['ids']);
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
     * @param CarClassification $CarClassification , case of navigation
     * @return object
     * @auth A.Soliman
     */


    public function navigate(Request $request, CarClassification $carClassification)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $example = new CarClassificationResource($this->carClassificationRepository->navigate($carClassification->id, $request->case, 'type', $request->type));
            return $example->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->carClassificationRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $carClassificationsNames = NameResource::collection($this->carClassificationRepository->names());
            return $carClassificationsNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->carClassificationRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
