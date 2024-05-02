<?php

namespace Modules\Common\Http\Controllers\Api\BillType;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\NameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\BillType\BillType;
use Modules\Common\Http\Requests\Api\BillType\BillTypeRequest;
use Modules\Common\Http\Requests\Api\BillType\NameRequest;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeRepository;
use Modules\Common\Transformers\Api\BillType\BillTypeForSettingResource;
use Modules\Common\Transformers\Api\BillType\BillTypeNameWithAccountsResource;
use Modules\Common\Transformers\Api\BillType\BillTypeResource;
use Modules\Common\Transformers\Api\BillType\NamesByTypeCollection;

class BillTypeController extends Controller
{

    public function __construct(private IBillTypeRepository $billTypeRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     * @update A.Soliman
     */
    public function index()
    {
        try {
            $billTypes = BillTypeResource::collection($this->billTypeRepository->all(
                // $with = ['BillTypeGroup', 'currencies', 'accumulatedBillType', 'changeBillType', 'inBillType', 'outBillType', 'billTypeUserSettings', 'billTypeDefaults', 'taxes'],
                [],
                [],
                ['id', 'name', 'group_id', 'type_id']
            ));
            return $billTypes->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     * update A.Soliman
     */
    public function store(BillTypeRequest $request)
    {
        try {
            $model = $this->billTypeRepository->createRequest($request->validated());
            $billType = $model->load('BillTypeGroup', 'currencies', 'accumulatedBillType', 'changeBillType', 'inBillType', 'outBillType', 'billTypeUserSettings', 'billTypeDefaults', 'taxes');
            $billType['billTypeDefaults']['billTypeUser'] = $billType['billTypeUserSettings'];
            $billType = new BillTypeResource($billType);
            return $billType->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param BillType $billType
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     * @update A.Soliman
     */
    public function show(BillType $billType)
    {
        try {
            $billType = $billType->load('BillTypeGroup', 'currencies', 'accumulatedBillType', 'changeBillType', 'inBillType', 'outBillType', 'billTypeUserSettings', 'billTypeDefaults');
            $billType['billTypeDefaults']['billTypeUser'] = $billType['billTypeUserSettings'];
            //TODO:temp users
            $billType['users'] = DB::table('temp_users')->select('id', 'name')->whereIn('id', $billType->billTypeUserSettings()->pluck('user_id')->toArray())->get();
            $billType = new BillTypeResource($billType);
            return $billType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param BillType $BillType
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     * update A.Soliman
     */
    public function update(BillType $billType, BillTypeRequest $request)
    {
        try {
            $this->billTypeRepository->updateRequest($billType, $request->validated());
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param BillType $billType
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->billTypeRepository->deleteRecords('c_bill_types', $request['ids']);
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
     * @param BillType $billType , case of navigation
     * @return object
     * @auth M.Mukhtar
     */
    public function navigate(Request $request, BillType $billType)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $billType = new BillTypeResource($this->billTypeRepository->navigate($billType->id, $request->case, 'type', $request->type));
            return $billType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            return $this->billTypeRepository->names();
            $billTypesNames = NameResource::collection($this->billTypeRepository->names());
            return $billTypesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function nameObj(NameRequest $request)
    {
        try {
            $billTypesNames = BillTypeNameWithAccountsResource::collection($this->billTypeRepository->nameObj($request));
            return $billTypesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getByType($typeId)
    {
        try {
            $billTypes = new NamesByTypeCollection($this->billTypeRepository->namesByType($typeId));
            return $billTypes->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->billTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     *
     * @param BillType $billType
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getBillTypeSetting(BillType $billType, Request $request)
    {
        // TODO: replace temp user 
        try {
            $billType = new BillTypeForSettingResource($this->billTypeRepository->getBillTypeSetting($billType, $request));
            return $billType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
