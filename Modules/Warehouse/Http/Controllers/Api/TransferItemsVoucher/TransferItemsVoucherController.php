<?php

namespace Modules\Warehouse\Http\Controllers\Api\TransferItemsVoucher;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Warehouse\Entities\Api\TransferItemsVoucher\TransferItemsVoucher;
use Modules\Warehouse\Http\Requests\Api\TransferItemsVoucher\TransferItemsVoucherRequest;
use Modules\Warehouse\Repositories\IRepositories\TransferItemsVoucher\ITransferItemsVoucherRepository;
use Modules\Warehouse\Transformers\Api\TransferItemsVoucher\TransferItemsVoucherResource;

class TransferItemsVoucherController extends Controller
{

    public function __construct(private ITransferItemsVoucherRepository $transferItemsVoucherRepository)
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
            $transferItemsVouchers = TransferItemsVoucherResource::collection($this->transferItemsVoucherRepository->all());
            return $transferItemsVouchers->additional(JsonResponse::success());
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
    public function store(TransferItemsVoucherRequest $request)
    {
        try {
            $model = $this->transferItemsVoucherRepository->createRequest($request->validated());
            $transferItemsVoucher = new TransferItemsVoucherResource($model);
            return $transferItemsVoucher->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param TransferItemsVoucher $transferItemsVoucher
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(TransferItemsVoucher $transferItemsVoucher)
    {
        try {
            $transferItemsVoucher['bills'] = $transferItemsVoucher->billsIds();
            $transferItemsVoucher = new TransferItemsVoucherResource($transferItemsVoucher->load('details'));
            return $transferItemsVoucher->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param TransferItemsVoucher $transferItemsVoucher
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(TransferItemsVoucherRequest $request, TransferItemsVoucher $transferItemsVoucher)
    {

        try {
            $this->transferItemsVoucherRepository->updateRequest($transferItemsVoucher, $request->validated());
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->transferItemsVoucherRepository->deleteRecords('w_transfer_items_vouchers', $request['ids'], ['w_transfer_items_voucher_details','c_bills']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * navigation.
     *
     * @param TransferItemsVoucher $transferItemsVoucher , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public  function navigate(Request $request,  TransferItemsVoucher $transferItemsVoucher)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $product = new TransferItemsVoucherResource($this->transferItemsVoucherRepository->navigate($transferItemsVoucher->id, $request->case));
            return $product->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
