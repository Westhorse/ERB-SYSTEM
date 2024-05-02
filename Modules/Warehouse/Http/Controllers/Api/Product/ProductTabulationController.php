<?php

namespace Modules\Warehouse\Http\Controllers\Api\Product;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  Modules\Warehouse\Entities\Api\Product\ProductTabulation;
use Modules\Warehouse\Http\Requests\Api\Product\ProductTabulationRequest;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductTabulationRepository;
use Modules\Warehouse\Transformers\Api\Product\ProductTabulationResource;

class ProductTabulationController extends Controller
{

    public function __construct(private IProductTabulationRepository $ProductTabulationRepository)
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
            $test = $this->ProductTabulationRepository->all(['productTabulationDetail']);
            $productTabulation = ProductTabulationResource::collection($test);
            return $productTabulation->additional(JsonResponse::success());
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
    public function store(ProductTabulationRequest $request)
    {
        try {

            $model = $this->ProductTabulationRepository->create($request->validated());


            if ($request->productTabulationDetail) $model->productTabulationDetail()->createMany($request->productTabulationDetail);
            $productTabulation = new ProductTabulationResource($model);

            return $productTabulation->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\ProductTabulation  $productTabulation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductTabulation $productTabulation)
    {
        try {
            $productTabulation = new ProductTabulationResource($productTabulation);
            return $productTabulation->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\ProductTabulation  $productTabulation
     * @return \Illuminate\Http\Response
     */
    public function update(ProductTabulationRequest $request, ProductTabulation $productTabulation)
    {
        try {
            $data = $request->except(['productTabulationDetail']);
            $productTabulation->update($data);
            if ($request->productTabulationDetail) {
                $productTabulationDetail = $request->productTabulationDetail;
                foreach ($productTabulationDetail as $productTabulationDet) {

                    $productTabulation->productTabulationDetail()->updateOrCreate(
                        [
                            'id' => (isset($productTabulationDet['id']) ? $productTabulationDet['id'] : null)
                        ],
                        $productTabulationDet
                    );
                }
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function destroyArray($ids)
    {
        foreach ($ids as $id) {
            DB::delete('delete from w_products_tabulation_details where id  = ?', [$id]);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product\ProductTabulation  $productTabulation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->ProductTabulationRepository->deleteRecords('w_products_tabulation', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->ProductTabulationRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, ProductTabulation $productTabulation)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))

                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $productTabulation = new ProductTabulationResource($this->ProductTabulationRepository->navigate($productTabulation->id, $request->case));
            return $productTabulation->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->ProductTabulationRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
