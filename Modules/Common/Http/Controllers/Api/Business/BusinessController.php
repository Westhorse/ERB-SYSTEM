<?php

namespace Modules\Common\Http\Controllers\Api\Business;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Business\BusinessResource;
use App\Helpers\JsonResponse;
use Modules\Common\Entities\Api\Business\Business;
use Modules\Common\Repositories\IRepositories\Business\IBusinessRepository;
use App\Http\Resources\NameResource;
use Modules\Common\Http\Requests\Api\Business\BusinessRequest;

class BusinessController extends Controller
{
    public function __construct(private IBusinessRepository $businessRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function index()
    {
        try {
            $business = BusinessResource::collection($this->businessRepository->all());
            return $business->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function store(BusinessRequest $request)
    {
        try {
            $model = $this->businessRepository->create($request->validated());
            $Business = new BusinessResource($model);
            return $Business->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(Business $business)
    {
        try {
            $business = new BusinessResource($business);
            return $business->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function update(BusinessRequest $request, Business $business)
    {
        try {
            $this->businessRepository->update($request->validated(), $business->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */

    public function destroy(Request $request)
    {
        try {
            $count = $this->businessRepository->deleteRecords('c_business', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function navigate(Request $request, Business $business)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $business = new BusinessResource($this->businessRepository->navigate($business->id, $request->case));
            return $business->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->businessRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $businessNames = NameResource::collection($this->businessRepository->names());
            return $businessNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->businessRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
