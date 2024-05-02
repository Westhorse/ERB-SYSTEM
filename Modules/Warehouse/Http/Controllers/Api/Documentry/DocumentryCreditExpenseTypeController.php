<?php

namespace Modules\Warehouse\Http\Controllers\Api\Documentry;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use  Modules\Warehouse\Entities\Api\Documentry\DocumentryCreditExpenseType;
use Modules\Warehouse\Http\Requests\Api\Documentry\DocumentryCreditExpenseTypeRequest;
use Modules\Warehouse\Repositories\IRepositories\Documentry\IDocumentryCreditExpenseTypeRepository;
use Modules\Warehouse\Transformers\Api\Documentry\DocumentryCreditExpenseTypeResource;

class DocumentryCreditExpenseTypeController extends Controller
{

    public function __construct(private IDocumentryCreditExpenseTypeRepository $creditExpenseTypeRepository)
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
            $documentryCreditExpenseType = DocumentryCreditExpenseTypeResource::collection($this->creditExpenseTypeRepository->all($with = ['shippingPolicy']));
            return $documentryCreditExpenseType->additional(JsonResponse::success());
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
    public function store(DocumentryCreditExpenseTypeRequest $request)
    {
        try {
            $model = $this->creditExpenseTypeRepository->create($request->except('shippingPolicy'));
            $model->shippingPolicy()->sync($request->shippingPolicy);
            $documentryCreditExpenseType = new DocumentryCreditExpenseTypeResource($model);
            return $documentryCreditExpenseType->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(DocumentryCreditExpenseType $documentryCreditExpenseType)
    {
        try {
            $documentryCreditExpenseType = new DocumentryCreditExpenseTypeResource($documentryCreditExpenseType);
            return $documentryCreditExpenseType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId()
    {


        try {
            return array_merge(['data' => ['id' => $this->creditExpenseTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentryCreditExpenseTypeRequest $request, DocumentryCreditExpenseType $documentryCreditExpenseType)
    {
        try {
            $this->creditExpenseTypeRepository->update($request->except('shippingPolicy'), $documentryCreditExpenseType->id);

            if (!empty($request->shippingPolicy)) {

                $documentryCreditExpenseType->shippingPolicy()->sync($request->shippingPolicy, true);
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        try {
            $count = $this->creditExpenseTypeRepository->deleteRecords('w_documentry_credit_expenses_type', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, $id)
    {

        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $documentryCreditExpenseType = new DocumentryCreditExpenseTypeResource($this->creditExpenseTypeRepository->navigate($id, $request->case));
            return $documentryCreditExpenseType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->creditExpenseTypeRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
