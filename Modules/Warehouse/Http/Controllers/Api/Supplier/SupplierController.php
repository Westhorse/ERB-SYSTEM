<?php

namespace Modules\Warehouse\Http\Controllers\Api\Supplier;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\Supplier\Supplier;
use Modules\Warehouse\Http\Requests\Api\Supplier\SupplierRequest;
use Modules\Warehouse\Repositories\IRepositories\Supplier\ISupplierRepository;
use Modules\Warehouse\Transformers\Api\Supplier\SupplierResource;

class SupplierController extends Controller
{

    public function __construct(private ISupplierRepository $supplierRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function index()
    {
        try {
            $suppliers = SupplierResource::collection($this->supplierRepository->all());
            return $suppliers->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function store(SupplierRequest $request)
    {
        try {
            $model = $this->supplierRepository->create($request->all());
            $supplier = new supplierResource($model);
            return $supplier->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Supplier $supplier
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(Supplier $supplier)
    {
        try {
            $supplier = new SupplierResource($supplier);
            return $supplier->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Supplier $Supplier
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function update(Supplier $supplier, SupplierRequest $request)
    {
        try {
            $this->supplierRepository->update($request->all(), $supplier->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function latestId(){
        try {
            return array_merge(['data' => ['id' => $this->supplierRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param Supplier $supplier
     * @return \Illuminate\Http\Response
     * @auth Developer
     */

    public function destroy(Request $request)
    {


        try {
            $count = $this->supplierRepository->deleteRecords('w_suppliers', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }



    }


    /**
     * navigation.
     *
     * @param Supplier $supplier , case of navigation
     * @return object
     * @auth Mohamed hesham
     */
    public function navigate(Request $request, Supplier $supplier)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $supplier = new SupplierResource($this->supplierRepository->navigate($supplier->id, $request->case));
            return $supplier->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

      /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     * @auth A.soliman
     */
    public function getNames()
    {
        try {
            $supplierNames = NameResource::collection($this->supplierRepository->names());
            return $supplierNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->supplierRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }
}
