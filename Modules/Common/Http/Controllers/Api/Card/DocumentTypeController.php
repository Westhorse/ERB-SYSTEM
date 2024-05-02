<?php

namespace Modules\Common\Http\Controllers\Api\Card;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Card\DocumentTypeResource;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\card\DocumentType;
use Modules\Common\Http\Requests\Api\Card\DocumentTypeRequest;
use Modules\Common\Repositories\IRepositories\IDocumentTypeRepository;

class DocumentTypeController extends Controller
{

    public function __construct(private IDocumentTypeRepository $documentTypeRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $documentTypes = DocumentTypeResource::collection(
                $this->documentTypeRepository->getAllByType($request->dtype)
            );
            return $documentTypes->additional(JsonResponse::success());
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
    public function store(DocumentTypeRequest $request)
    {
        try {
            $model = $this->documentTypeRepository->create($request->validated());
            $documentType = new DocumentTypeResource($model);
            return $documentType->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \Modules\Common\Entities\Api\card\DocumentType $documentType
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentType $documentType)
    {
        try {
            $documentType = new DocumentTypeResource($documentType);
            return $documentType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Modules\Common\Entities\Api\card\DocumentType $documentType
     * @return \Illuminate\Http\Response
     */
    public function update(DocumentTypeRequest $request, DocumentType $documentType)
    {
        try {
            $this->documentTypeRepository->update($request->validated(), $documentType->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \Modules\Common\Entities\Api\card\DocumentType $documentType
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        try {
            $count = $this->documentTypeRepository->deleteRecords('c_document_types', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, DocumentType $documentType)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $documentType = new DocumentTypeResource($this->documentTypeRepository->navigate($documentType->id, $request->case));
            return $documentType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->documentTypeRepository->codeGenerator('dtype', $request['dtype']));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->documentTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
