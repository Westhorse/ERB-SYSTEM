<?php

namespace Modules\Warehouse\Http\Controllers\Api\Inventory;

use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Resources\NameResource;
use Illuminate\Routing\Controller;
use Modules\Warehouse\Entities\Api\Inventory\Inventory;
use Modules\Warehouse\Http\Requests\Api\Inventory\ApproveRequest;
use Modules\Warehouse\Http\Requests\Api\Inventory\InventoryRequest;
use Modules\Warehouse\Http\Requests\Api\Inventory\ItemsRequest;
use Modules\Warehouse\Repositories\IRepositories\Inventory\IInventoryRepository;
use Modules\Warehouse\Transformers\Api\Inventory\InventoryResource;

class InventoryController extends Controller
{
    public function __construct(private IInventoryRepository $inventoryRepository)
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
            $inventorys = InventoryResource::collection($this->inventoryRepository->all());
            return $inventorys->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(InventoryRequest $request)
    {
        try {
            $inventory  = new InventoryResource($this->inventoryRepository->createRequest($request->validated()));
            return $inventory->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        try {
            $inventory = new InventoryResource($inventory->load('items'));
            return $inventory->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(InventoryRequest $request, Inventory $inventory)
    {
        try {
            return  $this->inventoryRepository->updateRequest($request->validated(), $inventory) ?
                JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY)) :
                JsonResponse::respondError(trans("responses.msg_cannot_updated"));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {

            $count = $this->inventoryRepository->deleteRecords('w_inventory', $request['ids'], ['w_inventory_items', 'w_inventory_lists']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function navigate(Request $request, Inventory $inventory)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tag = new InventoryResource($this->inventoryRepository->navigate($inventory->id, $request->case));
            return $tag->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->inventoryRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $unitNames = NameResource::collection($this->inventoryRepository->names());
            return $unitNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function getFillteredNames()
    {
        try {
            $unitNames = NameResource::collection($this->inventoryRepository->fillteredNames());
            return $unitNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->inventoryRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function gatherItems(ItemsRequest $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->inventoryRepository->gatherItems($request->validated()['inventory_ids']));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function approve(Request $request, Inventory $inventory)
    {
        try {
            return JsonResponse::respondSuccess('approve_success', $this->inventoryRepository->approve($request->all(), $inventory));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
