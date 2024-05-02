<?php

namespace Modules\Warehouse\Http\Controllers\Api\Guarantee;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Warehouse\Entities\Api\Guarantee\Guarantee;
use Modules\Warehouse\Http\Requests\Api\Guarantee\GuaranteeRequest;
use Modules\Warehouse\Repositories\IRepositories\Guarantee\IGuaranteeRepository;
use Modules\Warehouse\Transformers\Api\Guarantee\GuaranteeNameResource;
use Modules\Warehouse\Transformers\Api\Guarantee\GuaranteeResource;

class GuaranteeController extends Controller
{
    public function __construct(private IGuaranteeRepository $guaranteeRepository)
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
            $guarantees = GuaranteeResource::collection($this->guaranteeRepository->all());
            return $guarantees->additional(JsonResponse::success());
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
    public function store(GuaranteeRequest $request)
    {
        try {
            $model      = $this->guaranteeRepository->create($request->validated());
            $guarantee  = new GuaranteeResource($model);
            return $guarantee->additional(JsonResponse::savedSuccessfully());
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
    public function show(Guarantee $guarantee)
    {
        try {
            $guarantee = new GuaranteeResource($guarantee);
            return $guarantee->additional(JsonResponse::success());

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
    public function update(GuaranteeRequest $request, Guarantee $guarantee)
    {
        try {
            $this->guaranteeRepository->update($request->validated(), $guarantee->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));

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
            $count = $this->guaranteeRepository->deleteRecords('w_guarantee', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }


    }


    public function navigate(Request $request, Guarantee $guarantee)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tag = new GuaranteeResource($this->guaranteeRepository->navigate($guarantee->id, $request->case));
            return $tag->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->guaranteeRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }

    public function guaranteeName(Guarantee $guarantee)
    {
        $guarantee = new GuaranteeNameResource($guarantee);
        return JsonResponse::respondSuccess('success', $guarantee);
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->guaranteeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


}
