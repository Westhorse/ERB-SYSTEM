<?php

namespace Modules\Warehouse\Http\Controllers\Api\DocumentaryCreditType;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use  Modules\Warehouse\Entities\Api\DocumentaryCreditType\DocumentaryCreditType;
use Modules\Warehouse\Http\Requests\Api\DocumentaryCreditType\DocumentaryCreditTypeRequest;
use Modules\Warehouse\Repositories\IRepositories\DocumentaryCreditType\IDocumentaryCreditTypeRepository;
use Modules\Warehouse\Transformers\Api\DocumentaryCreditType\DocumentaryCreditTypeResource;

class DocumentaryCreditTypeController extends Controller
{

    public function __construct(private IDocumentaryCreditTypeRepository $documentaryCreditTypeRepository)
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
            $documentaryCreditTypes = DocumentaryCreditTypeResource::collection($this->documentaryCreditTypeRepository->all(
                [],
                [],
                ['id', 'code', 'name', 'created_at']
            ));
            return $documentaryCreditTypes->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function store(DocumentaryCreditTypeRequest $request)
    {
        try {
            $model = $this->documentaryCreditTypeRepository->create($request->validated());
            $documentaryCreditType = new DocumentaryCreditTypeResource($model);
            return $documentaryCreditType->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(DocumentaryCreditType $documentary_credit_type)
    {
        try {
            $documentaryCreditType = new DocumentaryCreditTypeResource($documentary_credit_type);
            return $documentaryCreditType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function update(DocumentaryCreditTypeRequest $request, DocumentaryCreditType $documentary_credit_type)
    {
        try {
            $this->documentaryCreditTypeRepository->update($request->validated(), $documentary_credit_type->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function destroy(Request $request)
    {
        try {
            $count = $this->documentaryCreditTypeRepository->deleteRecords('w_documentary_credit_types', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, DocumentaryCreditType $documentary_credit_type)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $unit = new DocumentaryCreditTypeResource($this->documentaryCreditTypeRepository->navigate($documentary_credit_type->id, $request->case));
            return $unit->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->documentaryCreditTypeRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->documentaryCreditTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
