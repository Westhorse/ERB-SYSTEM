<?php

namespace Modules\Common\Http\Controllers\Api\BillInstallments;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\BillInstallment\BillInstallmentResource;
use Modules\Common\Entities\Api\BillInstallments\BillInstallment;
use Illuminate\Http\Request;
use Modules\Common\Http\Requests\Api\BillInstallments\BillInstallmentRequest;
use Modules\Common\Repositories\IRepositories\BillInstallments\IBillInstallmentRepository;

class BillInstallmentController extends Controller
{
    public function __construct(private IBillInstallmentRepository $billInstallmentRepository)
    {
    }
    /**
     * Display the specified resource.
     *
     * @param BillInstallment $billInstallment
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Request $request)
    {
        try {
            $billInstallment = $this->billInstallmentRepository->show($request['billId']);
            if ($billInstallment == false) {
                return JsonResponse::respondSuccess(trans('NO_RECORD'), ['id' => null]);
            }
            $billInstallment = new BillInstallmentResource($billInstallment);
            return $billInstallment->additional(JsonResponse::success());
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
    public function requestHandling(BillInstallmentRequest $request)
    {
        try {
            $model = $this->billInstallmentRepository->billInstallmentHandling($request);
            if ($model == 'paid') {
                return JsonResponse::respondError('you_can_not_update_is_installment');
            } else {
                $billInstallment = new BillInstallmentResource($model);
                return $billInstallment->additional(JsonResponse::savedSuccessfully());
            }
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
