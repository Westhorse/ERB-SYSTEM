<?php

namespace Modules\Warehouse\Http\Controllers\Api\Offer;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use  Modules\Warehouse\Entities\Api\Offer\Offer;
use Modules\Warehouse\Http\Requests\Api\Offer\OfferStoreRequest;
use Modules\Warehouse\Repositories\IRepositories\Offer\IOfferRepository;
use Modules\Warehouse\Transformers\Api\Offer\OfferResource;

class OfferController extends Controller
{
    public function __construct(private IOfferRepository $offerRepository)
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
            $offers = OfferResource::collection($this->offerRepository->all($with=['warehouse','offerDetails']));
            return $offers->additional(JsonResponse::success());
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
    public function store(OfferStoreRequest $request)
    {
        try {
            $model = $this->offerRepository->create($request->except('offerDetails'));
            if ($request->offerDetails) $model->offerDetails()->createMany($request->offerDetails);
            $offer   = new OfferResource($model);
            return $offer->additional(JsonResponse::savedSuccessfully());
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
    public function show(Offer $offer)
    {
        try {
            $offer = new OfferResource($offer->load('warehouse','offerDetails'));
            return $offer->additional(JsonResponse::success());
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
    public function update(OfferStoreRequest $request, Offer $offer)
    {
        try {
            $this->offerRepository->update($request->except('offerDetails'), $offer->id);
            if (!empty($request->offerDetails)) {
                foreach ($request->offerDetails as $data) {
                    $offer->offerDetails()->updateOrCreate([
                        'id' => (isset($data['id']) ? $data['id'] : null)],
                        $data);
                }
            }
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
            $count = $this->offerRepository->deleteRecords('w_offers', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }




    }

    public function navigate(Request $request, Offer $offer)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $offer = new OfferResource($this->offerRepository->navigate($offer->id, $request->case));
            return $offer->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->offerRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->offerRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
