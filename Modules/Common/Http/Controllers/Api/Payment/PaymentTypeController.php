<?php

namespace Modules\Common\Http\Controllers\Api\Payment;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\payment\PaymentType;
use Modules\Common\Http\Requests\Api\Payment\PaymentTypeRequest;
use Modules\Common\Repositories\IRepositories\IPaymentTypeRepository;
use Modules\Common\Transformers\Api\payment\PaymentTypeResource;

class PaymentTypeController extends Controller
{

    public function __construct(private IPaymentTypeRepository $paymentTypeRepository)
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
            $paymentTypes = PaymentTypeResource::collection($this->paymentTypeRepository->all());
            return $paymentTypes->additional(JsonResponse::success());
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
    public function store(PaymentTypeRequest $request)
    {
        try {
            $model = $this->paymentTypeRepository->create($request->validated());
            $paymentType = new PaymentTypeResource($model);
            return $paymentType->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Modules\Common\Entities\Api\payment\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->paymentTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function show(PaymentType $paymentType)
    {
        try {
            $paymentType = new PaymentTypeResource($paymentType);
            return $paymentType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Modules\Common\Entities\Api\payment\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */
    public function update(PaymentTypeRequest $request, PaymentType $paymentType)
    {
        try {
            $this->paymentTypeRepository->update($request->validated(), $paymentType->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Modules\Common\Entities\Api\payment\PaymentType  $paymentType
     * @return \Illuminate\Http\Response
     */

    public function destroy(Request $request)
    {
        try {
            $count = $this->paymentTypeRepository->deleteRecords('c_payment_types', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->paymentTypeRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function navigate(Request $request, PaymentType $paymentType)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $paymentType = new PaymentTypeResource($this->paymentTypeRepository->navigate($paymentType->id, $request->case));
            return $paymentType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
