<?php

namespace Modules\Warehouse\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;


use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use  Modules\Warehouse\Entities\Api\Customer\Customer;
use Modules\Warehouse\Http\Requests\Api\Customer\CustomerRequest;
use Modules\Warehouse\Repositories\IRepositories\Customer\ICustomerRepository;
use Modules\Warehouse\Transformers\Api\Customer\CustomerResource;

class CustomerController extends Controller
{

    public function __construct(private ICustomerRepository $customerRepository)
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
            $customers = CustomerResource::collection($this->customerRepository->all());
            return $customers->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerRequest $request)
    {
        try {
            $model = $this->customerRepository->create($request->all());
            $customer = new CustomerResource($model);
            return $customer->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Customer $customer
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function show(Customer $customer)
    {
        try {
            $customer = new CustomerResource($customer);
            return $customer->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        try {
            $this->customerRepository->update($request->all(), $customer->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId(){


        try {
            return array_merge(['data' => ['id' => $this->customerRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Customer $customer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        try {
            $count = $this->customerRepository->deleteRecords('w_customers', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }

    public function navigate(Request $request, Customer $customer)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $customer = new CustomerResource($this->customerRepository->navigate($customer->id, $request->case));
            return $customer->additional(JsonResponse::success());
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
            $customersNames = NameResource::collection($this->customerRepository->names());
            return $customersNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->customerRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
