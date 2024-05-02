<?php

namespace Modules\Warehouse\Http\Controllers\Api\Product;

use App\Helpers\FileUploadAction;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use  Modules\Warehouse\Entities\Api\Product\PriceList;
use  Modules\Warehouse\Entities\Api\Product\Product;
use  Modules\Warehouse\Entities\Api\Product\ProductCategory;
use Modules\Warehouse\Http\Requests\Api\Product\ProductRequest;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductRepository;
use Modules\Warehouse\Transformers\Api\Product\ProductNameResource;
use Modules\Warehouse\Transformers\Api\Product\ProductResource;
use Modules\Warehouse\Transformers\Api\Tax\TaxNameResource;
use Modules\Warehouse\Transformers\Api\Unit\UnitNameResource;

class ProductController extends Controller
{


    public function __construct(private IProductRepository $productRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function index()
    {

        try {
            $products = ProductResource::collection($this->productRepository->all(
                $with = ['category', 'gurantee', 'images', 'suppliers', 'determinants', 'warehouses', 'alternatives', 'units', 'tags', 'productUnit', 'compounds', 'taxes']
            ));

            return $products->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */

    public function store(ProductRequest $request, FileUploadAction $uploadAction)
    {
        try {
            $model = $this->productRepository->create($request->except('images', 'suppliers', 'determinants', 'warehouses', 'alternatives', 'units', 'tags', 'taxes', 'compounds'));
            $uploadAction->executeBase64($model, $request['images']);
            if ($request->hasFile('images')) $uploadAction->execute($model, $request->file('images'), '');
            $model->suppliers()->sync($request->suppliers);
            $model->determinants()->sync($request->determinants);
            $model->taxes()->sync($request->taxes);
            $model->warehouses()->sync($request->warehouses);
            $model->alternatives()->sync($request->alternatives);
            $model->compounds()->sync($request->compounds);
            $model->units()->sync($request->units);
            $model->tags()->sync($request->tags);
            $product = new ProductResource($model);
            return $product->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function show(Product $product)
    {
        try {
            $product = new ProductResource($product->load('images', 'suppliers', 'determinants', 'warehouses', 'alternatives', 'units', 'tags', 'taxes', 'compounds'));
            return $product->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function update(ProductRequest $request, Product $product, FileUploadAction $uploadAction)
    {
        try {
            $data = $request->except('images', 'suppliers', 'determinants', 'warehouses', 'alternatives', 'units', 'tags', 'taxes', 'compounds');
            $this->productRepository->update($data, $product->id);

            if ($request->suppliers) $product->suppliers()->sync(customSync($request->suppliers, 'supplier_id'));
            if ($request->determinants) $product->determinants()->sync(customSync($request->determinants, 'determinant_id'));
            if ($request->productes) $product->productes()->sync(customSync($request->productes, 'product_id'));
            if ($request->warehouses) $product->warehouses()->sync(customSync($request->warehouses, 'warehouse_id'));
            if ($request->alternatives) $product->alternatives()->sync(customSync($request->alternatives, 'alternate_product_id'));
            if ($request->compounds) $product->compounds()->sync(customSync($request->compounds, 'src_product_id'));
            if ($request->units) $product->units()->sync(customSync($request->units, 'unit_id'));
            if ($request->tags)  $product->tags()->sync(customSync($request->tags, 'tag_id'));
            if ($request->taxes) $product->taxes()->sync(customSync($request->taxes, 'tax_id'));
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return \Illuminate\Http\Response
     * @auth Ahmed Helmy
     */
    public function destroy(Request $request)
    {

        try {
            $count = $this->productRepository->deleteRecords('w_products', $request['ids']);
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
     * @param Product $product , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public  function navigate(Request $request, Product $product)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $product = new ProductResource($this->productRepository->navigate($product->id, $request->case, 'product_type', $request->product_type));
            return $product->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    public function getCode(Request $request)
    {
        $code = Product::where('category_id', $request->category_id)->where('deleted_at', null)->orderBy('id', 'DESC')->pluck('code')->first();
        if (empty($code)) {
            $code = ProductCategory::where('id', $request->category_id)->where('deleted_at', null)->orderBy('id', 'DESC')->pluck('code')->first();
            if (!empty($code)) {
                $nextCode = $code . "0001";
                return JsonResponse::respondSuccess('success', $nextCode);
            }
        }
        $nextCode = getAutoGeneratedNextCode($code);
        $code1 =  Product::where('category_id', $request->category_id)->where('deleted_at', null)->where('code', $nextCode)->pluck('code')->first();
        while ($code1 != null) {
            $nextCode = getAutoGeneratedNextCode($code1);
            $code1 = Product::where('category_id', $request->category_id)->where('deleted_at', null)->where('code', $nextCode)->pluck('code')->first();
        }
        return JsonResponse::respondSuccess('success', $nextCode);
    }

    public function productUnits(Product $product)
    {
        try {
            $product = new UnitNameResource($product->load('units:id,name', 'productUnit:id,name'));
            return $product->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {

        try {
            $productNames = ProductNameResource::collection($this->productRepository->names());
            return $productNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function deletetree(Product $product)
    {
        try {
            $product->delete();
            return JsonResponse::respondSuccess(trans("responses.msg_multi_resources_Success"));
        } catch (\Exception $e) {
            return JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"));
        }
    }


    public function testProduct(Product $product, Request $request)
    {
    }

    public function getProductTaxes(Product $product, Request $request)
    {

        $productTaxes = DB::select(
            "SELECT Tax_Id,Amount_Type,Amount_Value,name FROM c_taxes_detail INNER JOIN c_taxes on
            c_taxes_detail.tax_id = c_taxes.id Where c_taxes.id in
            (Select tax_Id From w_products_taxes Where Product_Id = $request[product_id] )
            and (c_taxes_detail.country_id = $request[country_id])
            and('$request[bill_date]' BETWEEN c_taxes_detail.start_date and c_taxes_detail.end_date)"
        );

        return $productTaxes;
    }


    public function getConvert(Product $product, Request $request)
    {
        $convert =  $product->units()->where("unit_id", "=", $request["unit_id"])->pluck('convert_rate');
        return $convert;
    }




    public function test(Product $product)
    {
        $convert =  Product::find(1);

        return $convert->units;
    }




    public function getTest(PriceList $priceList, Request $request)
    {
        $priceList = $priceList->with(['priceListsDetail', 'priceListsDetail.product.category' => function ($query) use ($request) {
            $query->where([["code", "=", $request["country_id"]]]);
        }])->first();
        return $priceList;
    }


    public function getfield($name,  Request $request)
    {
        if ($request['columns'] === null and $request['values'] === null) {
            $query =  DB::table(config('tablename.' . $name))->get();
            return $query;
        } else {
            $query = DB::table(config('tablename.' . $name));
            $columns = $request['columns'];
            $values  = $request['values'];
            $conditions = array_combine($columns, $values);
            foreach ($conditions as $column => $value) {
                $result = $query->where($column, '=', $value)->select($columns)->get();
            }
            return $result;
        }
    }


    public function checkfield(Request $request)
    {
        try {
            $checkProductWarehouse =
                DB::table('w_products_warehouses')->where('product_id', $request["product_id"])
                ->where('warehouse_id', $request["warehouse_id"])->exists();
            return JsonResponse::respondSuccess('success', $checkProductWarehouse);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function insertfield(Request $request)
    {
        try {
            $insertProductWarehouse = DB::table('w_products_warehouses')->insert([
                ['product_id' => $request["product_id"], 'warehouse_id' => $request["warehouse_id"], 'created_at' => Carbon::now()]
            ]);
            return JsonResponse::respondSuccess('success', $insertProductWarehouse);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->productRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
