<?php

namespace Modules\Common\Http\Controllers\Api\Translations;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Translations\CaptionKeysResource;
use Modules\Common\Transformers\Api\Translations\CaptionResource;
use Modules\Common\Transformers\Api\Translations\CaptionsObjectResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Translations\Caption;
use Modules\Common\Http\Requests\Api\Translations\CaptionRequest;
use Modules\Common\Repositories\IRepositories\Translations\ICaptionRepository;

class CaptionController extends Controller
{

    public function __construct(private ICaptionRepository $captionRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function index()
    {
        try {
            $captions = CaptionResource::collection($this->captionRepository->all());
            return $captions->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getAllObjects()
    {
        try {
            $captions = CaptionsObjectResource::collection($this->captionRepository->getAllObjects())->collection->groupBy('code');
            return $captions;
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function store(CaptionRequest $request)
    {
        try {
            $model = $this->captionRepository->create($request->validated());
            $caption = new CaptionResource($model);
            return $caption->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Caption $caption
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Caption $caption)
    {
        try {
            $caption = new CaptionResource($caption);
            return $caption->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Caption $caption
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Caption $caption, CaptionRequest $request)
    {
        try {
            $this->captionRepository->update($request->validated(), $caption->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $system_language
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        $databaseName = DB::connection()->getDatabaseName();
        $destroyDenied = [];
        foreach ($request->ids as $id) {
            if (checkColumnUsed($databaseName, 'c_captions', 'id', $id)) {
                $destroyDenied[] = [$id];
            } else {
                $this->captionRepository->delete($id);
            }
        }
        if (count($destroyDenied) == 1) {
            return JsonResponse::respondError(trans("responses.msg_cannot_deleted"));
        } elseif (count($destroyDenied) > 1) {
            return JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"));
        }
        return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
    }

    /**
     * Display the ids and keys resource.
     *
     * 
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getKyes()
    {
        try {
            $captions = CaptionKeysResource::collection($this->captionRepository->fetchKeys());
            return $captions->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    /**
     * Display the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getByCode(Request $request)
    {
        try {
            $caption = CaptionResource::collection($this->captionRepository->fetchByCode($request->code));
            return $caption->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
