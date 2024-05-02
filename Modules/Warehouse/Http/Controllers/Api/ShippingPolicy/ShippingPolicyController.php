<?php

namespace Modules\Warehouse\Http\Controllers\Api\ShippingPolicy;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\ShippingPolicy\ShippingPolicy;
use Modules\Warehouse\Http\Requests\Api\ShppingPolicy\ShippingPolicyRequest;
use Modules\Warehouse\Repositories\IRepositories\ShippingPolicy\IShippingPolicyRepository;
use Modules\Warehouse\Transformers\Api\ShippingPolicy\ShippingPolicyResource;

class ShippingPolicyController extends Controller
{
    public function __construct(private IShippingPolicyRepository $shippingPolicyRepository)
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
            $shippingPolicies = ShippingPolicyResource::collection($this->shippingPolicyRepository->all());
            return $shippingPolicies->additional(JsonResponse::success());
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
    public function store(ShippingPolicyRequest  $request)
    {
        try {
            $model      = $this->shippingPolicyRepository->create($request->validated());
            $shippingPolicy  = new ShippingPolicyResource($model);
            return $shippingPolicy->additional(JsonResponse::savedSuccessfully());
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
    public function show(ShippingPolicy $shipping_policy)
    {
        try {
            $shippingPolicy = new ShippingPolicyResource($shipping_policy);
            return $shippingPolicy->additional(JsonResponse::success());
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
    public function update(ShippingPolicyRequest $request, ShippingPolicy $shipping_policy)
    {
        try {
            $this->shippingPolicyRepository->update($request->validated(), $shipping_policy->id);
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
            $count = $this->shippingPolicyRepository->deleteRecords('w_shipping_policy', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, ShippingPolicy $shipping_policy)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tag = new ShippingPolicyResource($this->shippingPolicyRepository->navigate($shipping_policy->id, $request->case));
            return $tag->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->shippingPolicyRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $shippingPolicyNames = NameResource::collection($this->shippingPolicyRepository->names());
            return $shippingPolicyNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->shippingPolicyRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
