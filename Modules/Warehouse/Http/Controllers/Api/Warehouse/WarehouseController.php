<?php

namespace Modules\Warehouse\Http\Controllers\Api\Warehouse;

use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\Warehouse\Warehouse;
use Modules\Warehouse\Http\Requests\Api\Warehouse\WarehouseRequest;
use Modules\Warehouse\Repositories\IRepositories\Warehouse\IWarehouseRepository;
use Modules\Warehouse\Transformers\Api\Warehouse\WarehouseResource;

class WarehouseController extends Controller
{
    public function __construct(private IWarehouseRepository $warehouseRepository)
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
            $warehouses = WarehouseResource::collection($this->warehouseRepository->all($with = ['children']));
            return $warehouses->additional(JsonResponse::success());
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
    public function store(WarehouseRequest $request)
    {

        try {
            $model = $this->warehouseRepository->create($request->all());
            $warehouse = new WarehouseResource($model);
            return $warehouse->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Warehouse $warehouse
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function show(Warehouse $warehouse)
    {
        try {
            $warehouse = new WarehouseResource($warehouse);
            return $warehouse->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Warehouse $warehouse
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function update(Warehouse $warehouse, WarehouseRequest $request)
    {
        try {
            $this->warehouseRepository->update($request->all(), $warehouse->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Warehouse $warehouse
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public
    function destroy(Request $request)
    {


        try {
            $count = $this->warehouseRepository->deleteRecords('w_warehouses', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }


    }


    public function getCodeWhenHasParent(Request $request)
    {
        return JsonResponse::respondSuccess('success', $this->warehouseRepository->childValue('id', $request['parent_id']));
    }

    /**
     * navigation.
     *
     * @param Warehouse $warehouse , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Warehouse $warehouse)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $warehouse_resource = new WarehouseResource($this->warehouseRepository->navigate($warehouse->id, $request->case, 'type', $request->type));
            return $warehouse_resource->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getParents()
    {

        try {
            $warehouse = WarehouseResource::collection($this->warehouseRepository->getParents());
            return $warehouse->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->warehouseRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function getNames()
    {
        try {
            $warehouseNames = NameResource::collection($this->warehouseRepository->names());
            return $warehouseNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {

        try {
            return array_merge(['data' => ['id' => $this->warehouseRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
