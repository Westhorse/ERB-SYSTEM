<?php

namespace Modules\Warehouse\Http\Controllers\Api\Product;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Warehouse\Entities\Api\Product\Determinant;
use Modules\Warehouse\Http\Requests\Api\Product\DeterminantRequest;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductDeterminantRepository;
use Modules\Warehouse\Transformers\Api\Product\DeterminantResource;
use Modules\Warehouse\Transformers\Api\Product\ProductDeterminantNameResource;

class DeterminantController extends Controller
{

    public function __construct(private IProductDeterminantRepository $productDeterminantRepository)
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
            $determinants = DeterminantResource::collection($this->productDeterminantRepository->all());
            return $determinants->additional(JsonResponse::success());
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
    public function store(DeterminantRequest $request)
    {
        try {
            $model = $this->productDeterminantRepository->create($request->all());
            if ($request->determinantsDetail) $model->determinantsDetail()->createMany($request->determinantsDetail);
            $determinant = new DeterminantResource($model);
            return $determinant->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product\ProductDeterminant  $productDeterminant
     * @return \Illuminate\Http\Response
     */
    public function show(Determinant $Determinant)
    {
        try {
            $determinant = new DeterminantResource($Determinant);
            return $determinant->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $determinantNames = ProductDeterminantNameResource::collection($this->productDeterminantRepository->names());
            return $determinantNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product\ProductDeterminant  $productDeterminant
     * @return \Illuminate\Http\Response
     */
    public function update(DeterminantRequest $request, Determinant $determinant)
    {
        try {
            $data = $request->except(['determinantsDetail']);
            $determinant->update($data);
            if ($request->determinantsDetail) {
                $determinantsDetail = $request->determinantsDetail;
                foreach ($determinantsDetail as $determinantsDet) {

                    $determinant->determinantsDetail()->updateOrCreate(
                        [
                            'id' => (isset($determinantsDet['id']) ? $determinantsDet['id'] : null)
                        ],
                        $determinantsDet
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
     * @param  \App\Models\Product\ProductDeterminant  $productDeterminant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->productDeterminantRepository->deleteRecords('w_determinants', $request['ids']);
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
            return JsonResponse::respondSuccess('success', $this->productDeterminantRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function navigate(Request $request, Determinant $determinant)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $determinant = new DeterminantResource($this->productDeterminantRepository->navigate($determinant->id, $request->case));
            return $determinant->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->productDeterminantRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
