<?php

namespace Modules\Warehouse\Http\Controllers\Api\Product;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\Product\ProductCategory;
use Modules\Warehouse\Http\Requests\Api\Product\ProductCategoryRequest;
use Modules\Warehouse\Http\Requests\Api\Product\ProductCategoryTypeRequest;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductCategoryRepository;
use Modules\Warehouse\Transformers\Api\Product\ProductCategoryConstResource;
use Modules\Warehouse\Transformers\Api\Product\ProductCategoryResource;
use Modules\Warehouse\Transformers\Api\Product\ProductCategoryTreeResource;

class ProductCategoryController extends Controller
{

    public function __construct(private IProductCategoryRepository $productCategoryRepository)
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
            $productCategories = ProductCategoryResource::collection($this->productCategoryRepository->all(
                ['products', 'taxes:id'],
                [],
                ['id', 'code', 'name', 'created_at']
            ));
            return $productCategories->additional(JsonResponse::success());
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
    public function store(ProductCategoryRequest $request)
    {
        try {
            $model = $this->productCategoryRepository->create($request->validated());
            $productCategory = new ProductCategoryResource($model);

            if ($request->filled('taxes')) {
                $taxIds = $request->taxes;
                $model->taxes()->sync($taxIds);
            }

            return $productCategory->additional(JsonResponse::savedSuccessfully());
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
    public function show(ProductCategory $productCategory)
    {
        try {
            $productCategory = new ProductCategoryResource($productCategory->load('taxes:id'));
            return $productCategory->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getParents()
    {
        try {
            // $data = $this->productCategoryRepository->getdata() ;
            // return $data;
            $productCategories = ProductCategoryTreeResource::collection($this->productCategoryRepository->all(['products', 'taxes:id' , 'children']));
            return $productCategories->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function showProduct(ProductCategory $productCategory)
    {

            $productCategory = $productCategory->products;
            return $productCategory;

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        try {
            $this->productCategoryRepository->update($request->validated(), $productCategory->id);

            if ($request->filled('taxes')) {
                $taxIds = $request->taxes;
                $productCategory->taxes()->sync($taxIds);
            }

            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function updateProduct(Request $request, ProductCategory $productCategory)
    {
        try {
            foreach ($request['children'] as $child) {
               $productCategory->products()->where('id' , $child['id'])->update([
                'sales_price' => $child['sales_price'],
                'cost_price' => $child['cost_price'] ,
                'min_sales_price' => $child['min_sales_price'] ,
               ]);
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
            $count = $this->productCategoryRepository->deleteRecords('w_product_categories', $request['ids'], ['w_product_categories_taxes']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, ProductCategory $productCategory)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $productCategory = new ProductCategoryResource($this->productCategoryRepository->navigate($productCategory->id, $request->case, 'product_type', $request->product_type));
            return $productCategory->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->productCategoryRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCodeWhenHasParent(Request $request)
    {
        return JsonResponse::respondSuccess('success', $this->productCategoryRepository->childValue('id', $request['parent_id']));
    }

    public function getConstants()
    {
        try {
            $productCategoryConstants = new ProductCategoryConstResource(config('constants.product_category_constants_' . app()->getLocale()));

            return $productCategoryConstants->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $productCategoryNames = NameResource::collection($this->productCategoryRepository->names());
            return $productCategoryNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->productCategoryRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNamesWithTypeIsFixedAsset()
    {
        try {
            $productCategories = NameResource::collection($this->productCategoryRepository->namesWithTypeIsFixedAsset());
            return $productCategories->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function getNamesWithType(ProductCategoryTypeRequest $request)
    {
        try {
            $productCategories = NameResource::collection($this->productCategoryRepository->namesWithType($request['product_type']));
            return $productCategories->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
