<?php

namespace Modules\Common\Http\Controllers\Api\Bills;

use App\Helpers\JsonResponse;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Bills\Bill;
use Modules\Common\Entities\Api\BillType\BillType;
use Modules\Common\Http\Requests\Api\Bills\BillRequest;
use Modules\Common\Http\Requests\Api\Bills\ItemRequest;
use Modules\Common\Repositories\IRepositories\Bill\IBillRepository;
use Modules\Common\Transformers\Api\Bills\BillResource;

class BillController extends Controller
{

    public function __construct(private IBillRepository $billRepository)
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
            $bills = BillResource::collection($this->billRepository->all(
                ['items', 'effects', 'paymentTerms'],
                [],
                ['id', 'code', 'bill_date', 'payment_type']
            ));
            return $bills->additional(JsonResponse::success());
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
    public function store(BillRequest $request)
    {
        try {
            $model = $this->billRepository->createBill($request->validated());
            $bill = new BillResource($model);
            return $bill->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Bill $bill
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Bill $bill)
    {
        try {
            $bill = new BillResource($bill->load('items', 'effects', 'paymentTerms'));
            return $bill->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Bill $Bill
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Bill $bill, BillRequest $request)
    {
        try {
            $this->billRepository->updateBill($bill, $request->validated());
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Bill $bill
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->billRepository->deleteRecords('c_bills', $request['ids'], ['c_bills_items', 'c_bill_types', 'c_bill_effects', 'c_bill_payment_terms']);
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
     * @param Bill $bill , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Bill $bill)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $bill = new BillResource($this->billRepository->navigate($bill->id, $request->case, 'type', $request->type));
            return $bill->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * getNames.
     *
     * @return Collection
     * @auth A.Soliman
     */
    public function getNames()
    {
        try {
            $billsNames = NameResource::collection($this->billRepository->names());
            return $billsNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * getCode.
     * @auth A.Soliman
     */
    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->billRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * latestId.
     * @auth A.Soliman
     */
    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->billRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * itemBalance.
     * @auth A.Soliman
     */
    public function itemBalance(ItemRequest $request)
    {
        try {
            return  array_merge(['data' => $this->billRepository->warehousesProductBalance($request->validated())], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function newproduct(Request $request)
    {
        $priceList = BillType::where("cost_price_effect", '=', 1)->select('id', 'cost_price_effect')->first();
        $er = Bill::where("bill_type_id", '=', $priceList->id)->latest('bill_date')->with(['items' => function ($query) use ($request) {
            $query->where([["product_id", "=", $request["product_id"]]])->pluck('unit_price');
        }])->first();
        if ($er->BillType['cost_price_effect']) {
            return $er;
        } else {
            return DB::table('w_products')->where("id",  $request["product_id"])->pluck('cost_way');
        };
    }

    public function average(Request $request)
    {

        $total_price_five = DB::select(
            "SELECT SUM(Converted_add_qty) as Add_QTY, SUM(Total_Price) AS Total_Price from
              c_bills_items INNER JOIN c_bills on c_bills_items.bill_id = c_bills.id
              WHERE
             (c_bills_items.product_id = $request[product_id]) AND
             (c_bills.bill_type_id in (SELECT id FROM c_bill_types
             Where cost_price_effect = 1 and type_id in (2,5)))"
        );
        $total_price_four = DB::select(
            "SELECT SUM(converted_issue_qty) as Add_QTY, SUM(Total_Price) AS Total_Price from
              c_bills_items INNER JOIN c_bills on c_bills_items.bill_id = c_bills.id
              WHERE
             (c_bills_items.product_id = $request[product_id]) AND
             (c_bills.bill_type_id in (SELECT id FROM c_bill_types
             Where cost_price_effect = 1 and type_id in (4)))"
        );
        $price_type_five =  $total_price_five[0]->Total_Price;
        $Converted_type_five =  $total_price_five[0]->Add_QTY;

        $price_type_four =  $total_price_four[0]->Total_Price;
        $Converted_type_four =  $total_price_four[0]->Add_QTY;

        $min_abov =  $price_type_five - $price_type_four;
        $min_down =  $Converted_type_five - $Converted_type_four;
        return $min_abov / $min_down;
    }
}
