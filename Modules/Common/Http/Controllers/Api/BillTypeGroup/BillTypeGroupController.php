<?php

namespace Modules\Common\Http\Controllers\Api\BillTypeGroup;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\BillTypeGroup\BillTypeGroupResource;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\BillTypeGroup\BillTypeGroup;
use Modules\Common\Http\Requests\Api\BillTypeGroup\BillTypeGroupRequest;
use Modules\Common\Repositories\IRepositories\BillTypeGroup\IBillTypeGroupRepository;

class BillTypeGroupController extends Controller
{

    public function __construct(private IBillTypeGroupRepository $billTypeGroupRepository)
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
            $billTypesGroups = BillTypeGroupResource::collection($this->billTypeGroupRepository->all());
            return $billTypesGroups->additional(JsonResponse::success());
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
    public function store(BillTypeGroupRequest $request)
    {
        try {
            $model = $this->billTypeGroupRepository->create($request->validated());
            $billTypesGroup = new BillTypeGroupResource($model);
            return $billTypesGroup->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BillTypeGroup $bill_types_group
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(BillTypeGroup $billTypesGroup)
    {
        try {
            $billTypesGroup = new BillTypeGroupResource($billTypesGroup);
            return $billTypesGroup->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param BillTypeGroup $bill_types_group
     * @return \Illuminate\Http\Response
     */
    public function update(BillTypeGroup $billTypesGroup, BillTypeGroupRequest $request)
    {
        try {
            $this->billTypeGroupRepository->update($request->validated(), $billTypesGroup->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BillTypeGroup $bill_types_group
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->billTypeGroupRepository->deleteRecords('c_bill_types_groups', $request['ids']);
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
     * @param BillTypeGroup $bill_types_group, case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, BillTypeGroup $billTypesGroup)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $billTypesGroup = new BillTypeGroupResource($this->billTypeGroupRepository->navigate($billTypesGroup->id, $request->case));
            return $billTypesGroup->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->billTypeGroupRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getNames()
    {
        try {
            $billTypesGroupsNames = NameResource::collection($this->billTypeGroupRepository->names());
            return $billTypesGroupsNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->billTypeGroupRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
