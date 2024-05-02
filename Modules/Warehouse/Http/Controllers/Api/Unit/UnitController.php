<?php

namespace Modules\Warehouse\Http\Controllers\Api\Unit;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\Unit\Unit;
use Modules\Warehouse\Http\Requests\Api\Unit\UnitRequest;
use Modules\Warehouse\Repositories\IRepositories\Unit\IUnitRepository;
use Modules\Warehouse\Transformers\Api\Unit\UnitResource;

class UnitController extends Controller
{
    public function __construct(private IUnitRepository $unitRepository)
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
            $units = UnitResource::collection($this->unitRepository->all());
            return $units->additional(JsonResponse::success());
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
    public function store(UnitRequest $request)
    {
        try {
            $model = $this->unitRepository->create($request->validated());
            $unit = new UnitResource($model);
            return $unit->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Unit $unit
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(Unit $unit)
    {
        try {
            $unit = new UnitResource($unit);
            return $unit->additional(JsonResponse::success());
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
    public function update(UnitRequest $request, Unit $unit)
    {

        try {
            $this->unitRepository->update($request->validated(), $unit->id);
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
            $count = $this->unitRepository->deleteRecords('w_units', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }

    public function navigate(Request $request, Unit $unit)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $unit = new UnitResource($this->unitRepository->navigate($unit->id, $request->case));
            return $unit->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->unitRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getNames()
    {
        try {
            $unitNames = NameResource::collection($this->unitRepository->names());
            return $unitNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->unitRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
