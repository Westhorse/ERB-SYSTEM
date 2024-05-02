<?php

namespace Modules\Common\Http\Controllers\Api\Translations;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Translations\DefaultValueCodeResource;
use Modules\Common\Transformers\Api\Translations\DefaultValueResource;
use Modules\Common\Repositories\Translations\IDefaultValueRepository;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Translations\DefaultValue;
use Modules\Common\Http\Requests\Api\Translations\DefaultValueRequest;
use Modules\Common\Repositories\IRepositories\Translations\IDefaultValueRepository as TranslationsIDefaultValueRepository;

class DefaultValueController extends Controller
{

    public function __construct(private TranslationsIDefaultValueRepository $defaultValueRepository)
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
            $defaultValues = DefaultValueResource::collection($this->defaultValueRepository->all());
            return $defaultValues->additional(JsonResponse::success());
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
    public function store(DefaultValueRequest $request)
    {
        try {
            $model = $this->defaultValueRepository->create($request->validated());
            $defaultValue = new DefaultValueResource($model);
            return $defaultValue->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param DefaultValue $defaultValue
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(DefaultValue $defaultValue)
    {
        try {
            $defaultValue = new DefaultValueResource($defaultValue);
            return $defaultValue->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param DefaultValue $defaultValue
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(DefaultValue $defaultValue, DefaultValueRequest $request)
    {
        try {
            $this->defaultValueRepository->update($request->validated(), $defaultValue->id);
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
        try {
            $count = $this->defaultValueRepository->deleteRecords('c_default_values', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $code
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getByCode($code)
    {
        try {
            $defaultValue = DefaultValueResource::collection($this->defaultValueRepository->getByCode($code));
            return $defaultValue->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $code
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function getCode()
    {
        try {
            $code = DefaultValueCodeResource::collection($this->defaultValueRepository->getCode());
            return $code->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
