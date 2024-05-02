<?php

namespace Modules\Warehouse\Http\Controllers\Api\Product;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use  Modules\Warehouse\Entities\Api\Product\PriceList;
use Modules\Warehouse\Http\Requests\Api\Product\PriceListRequest;
use Modules\Warehouse\Repositories\IRepositories\Product\IPriceListRepository;
use Modules\Warehouse\Rules\PriceArray;
use Modules\Warehouse\Transformers\Api\Product\PriceListResource;

class PriceListController extends Controller
{

    public function __construct(private IPriceListRepository $PriceListRepository)
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
            $test = $this->PriceListRepository->all(['priceListsDetail', 'priceListsDetail.product', 'priceListsDetail.unit']);
            $priceLists = PriceListResource::collection($test);
            return $priceLists->additional(JsonResponse::success());
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
    public function store(PriceListRequest $request)
    {
        try {
            $model = $this->PriceListRepository->create($request->all());

            $validator = Validator::make(request()->all(), [
                "priceListsDetail" => new PriceArray($model->id),
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'The given data is invalid',
                    'errors' => $validator->errors(),
                    'status' => 422,
                ]);
            }
            if ($request->priceListsDetail) $model->priceListsDetail()->createMany($request->priceListsDetail);
            $priceList = new PriceListResource($model);

            return $priceList->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function show(PriceList $priceList)
    {
        try {
            $priceList = new priceListResource($priceList);
            return $priceList->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */
    public function update(PriceListRequest $request, PriceList $priceList)
    {
        try {
            $data = $request->except(['priceListsDetail']);
            $priceList->update($data);
            if ($request->priceListsDetail) {
                $priceListsDetail = $request->priceListsDetail;
                foreach ($priceListsDetail as $priceListsDet) {
                    $priceList->priceListsDetail()->updateOrCreate(
                        [
                            'id' => (isset($priceListsDet['id']) ? $priceListsDet['id'] : null)
                        ],
                        $priceListsDet
                    );
                }
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\PriceList  $priceList
     * @return \Illuminate\Http\Response
     */


    public function destroy(Request $request)
    {
        try {
            $count = $this->PriceListRepository->deleteRecords('w_price_lists', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function destroyArray($ids)
    {
        foreach ($ids as $id) {
            DB::delete('delete from w_price_list_details where id  = ?', [$id]);
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->PriceListRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    public function navigate(Request $request, PriceList $priceList)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))

                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $priceList = new priceListResource($this->PriceListRepository->navigate($priceList->id, $request->case));
            return $priceList->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->PriceListRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
