<?php

namespace Modules\POS\Http\Controllers\Api\CashTransfer;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\POS\Entities\Api\CashTransfer\CashTransfer;
use Modules\POS\Http\Requests\Api\CashTransfer\CashTransferRequest;
use Modules\POS\Repositories\IRepositories\CashTransfer\ICashTransferRepository;
use Modules\POS\Transformers\Api\CashTransfer\CashTransferResource;

class CashTransferController extends Controller
{

    public function __construct(private ICashTransferRepository $cashTransferRepository)
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
            $cashTransfers = CashTransferResource::collection($this->cashTransferRepository->fetchAll());
            return $cashTransfers->additional(JsonResponse::success());
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
    public function store(CashTransferRequest $request)
    {
        try {
            $cashTransfer = new CashTransferResource($this->cashTransferRepository->createRequest($request->validated()));
            return $cashTransfer->additional(JsonResponse::savedSuccessfully());
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
    public function show(CashTransfer $cashTransfer)
    {
        try {
            // $cashTransfer = new CashTransferResource($cashTransfer->load('cashTransferDetails:id,transfer_id,part_id,part_count'));
            $cashTransfer = new CashTransferResource($this->cashTransferRepository->showRecord($cashTransfer));
            return $cashTransfer->additional(JsonResponse::success());
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
    public function update(CashTransfer $cashTransfer, CashTransferRequest $request)
    {
        try {
            $this->cashTransferRepository->updateRequest($cashTransfer, $request->validated());
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
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
            $count = $this->cashTransferRepository->deleteRecords('pos_cash_transfer', $request['ids'], ['pos_cash_transfer_detail']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, CashTransfer $cashTransfer)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $cashTransfer = new CashTransferResource($this->cashTransferRepository->navigate($cashTransfer->id, $request->case, 'type', $request->type));
            return $cashTransfer->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->cashTransferRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
