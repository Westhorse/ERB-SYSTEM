<?php

namespace Modules\Common\Http\Controllers\Api\DocumentIssuer;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\DocumentIssuer\DocumentIssuer;
use Modules\Common\Http\Requests\Api\DocumentIssuer\DocumentIssuerRequest;
use Modules\Common\Repositories\IRepositories\IDocumentIssuerRepository;
use Modules\Common\Transformers\Api\documentIssuer\DocumentIssuerResource;

use function trans;

class DocumentIssuerController extends Controller
{

    public function __construct(private IDocumentIssuerRepository $documentIssuerRepository)
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
            $documentIssuer = DocumentIssuerResource::collection($this->documentIssuerRepository->all());
            return $documentIssuer->additional(JsonResponse::success());
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
    public function store(DocumentIssuerRequest $request)
    {
        try {
            $model = $this->documentIssuerRepository->create($request->all());
            $documentIssuer = new DocumentIssuerResource($model);
            return $documentIssuer->additional(JsonResponse::savedSuccessfully());
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
    public function show(DocumentIssuer $documentIssuer)
    {
        try {
            $documentIssuer = new DocumentIssuerResource($documentIssuer);
            return $documentIssuer->additional(JsonResponse::success());
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
    public function update(DocumentIssuerRequest $request, DocumentIssuer $documentIssuer)
    {
        try {
            $this->documentIssuerRepository->update($request->all(), $documentIssuer->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId(){
        try {
            return array_merge(['data' => ['id' => $this->documentIssuerRepository->latestId()]], JsonResponse::success());
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
            $count = $this->documentIssuerRepository->deleteRecords('c_document_issuer', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, DocumentIssuer $documentIssuer)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $example = new DocumentIssuerResource($this->documentIssuerRepository->navigate($documentIssuer->id, $request->case, 'type', $request->type));
            return $example->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->documentIssuerRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
