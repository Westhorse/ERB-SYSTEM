<?php

namespace Modules\Common\Http\Controllers\Api\Tax;

use App\Http\Controllers\Controller;
use App\Helpers\JsonResponse;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Modules\Common\Transformers\Api\Tax\TaxResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Tax\Tax;
use Modules\Common\Entities\Api\Tax\TaxDetail;
use Modules\Common\Http\Requests\Api\Tax\TaxRequest;
use Modules\Common\Repositories\IRepositories\Tax\ITaxRepository;

class TaxController extends Controller
{

    public function __construct(private ITaxRepository $taxRepository)
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
            $taxes = TaxResource::collection($this->taxRepository->all($with = ['countries']));
            return $taxes->additional(JsonResponse::success());
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
    public function store(TaxRequest $request)
    {
        try {
            $model = $this->taxRepository->create($request->except('countries'));

            //            $validator = Validator::make(request()->all(), [
            //                "countries" => new CustomTaxArray($request->countries),
            //            ]);
            //
            //            if ($validator->fails()) {
            //                return response()->json([
            //                    'message' => 'The given data is invalid',
            //                    'errors' => $validator->errors(),
            //                    'status' => 422,
            //                ]);
            //            }

            if (!empty($request->countries)) {

                foreach ($request->countries as $country) {


                    TaxDetail::create([
                        'tax_id' => $model->id,
                        'amount_type' => $country['amount_type'],
                        'amount_value' => $country['amount_value'],
                        'country_id' => $country['country_id'],
                        'end_date' => $country['end_date'],
                        'start_date' => $country['start_date'],
                        'impact' => $country['impact'],
                        'sales_tax_account_id' => $country['sales_tax_account_id'],
                        'purchase_tax_account_id' => $country['purchase_tax_account_id'],
                    ]);
                }
            }
            //         $model->countries()->sync($request->countries);
            $tax = new TaxResource($model);
            return $tax->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->taxRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */

    public function show(Tax $tax)
    {
        try {
            $tax = new TaxResource($tax->load('countries'));
            return $tax->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function update(Request $request, Tax $tax)
    {
        try {


            $tax->update($request->except('countries'));

            //            $validator = Validator::make(request()->all(), [
            //                "countries" => new CustomTaxArray($request->countries),
            //            ]);
            //
            //            if ($validator->fails()) {
            //                return response()->json([
            //                    'message' => 'The given data is invalid',
            //                    'errors' => $validator->errors(),
            //                    'status' => 422,
            //                ]);
            //            }
            if (!empty($request->countries)) {
                //                $this->taxCountrySync($tax, $request->countries, ['tax_id', 'country_id'], 'c_taxes_detail');


                TaxDetail::where('tax_id', $tax->id)->delete();

                foreach ($request->countries as $country) {


                    TaxDetail::create([
                        'amount_type' => $country['amount_type'],
                        'amount_value' => $country['amount_value'],
                        'country_id' => $country['country_id'],
                        'end_date' => $country['end_date'],
                        'start_date' => $country['start_date'],
                        'impact' => $country['impact'],
                        'tax_id' => $tax->id,
                    ]);
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
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */

    public function destroy(Request $request)
    {
        $databaseName = DB::connection()->getDatabaseName();
        $destroyDenied = [];
        foreach ($request->ids as $id) {
            if (checkColumnUsed($databaseName, 'c_taxes', 'id', $id, ['c_taxes_detail'])) {
                $destroyDenied[] = [$id];
            } else {
                DB::delete('delete from c_taxes_detail where tax_id = ?', [$id]);

                $this->taxRepository->delete($id);
            }
        }
        if (count($destroyDenied) == 1) {
            return JsonResponse::respondError(trans("responses.msg_cannot_deleted"));
        } elseif (count($destroyDenied) > 1) {
            return JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"));
        }
        return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
    }


    public function navigate(Request $request, Tax $tax)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tax = new TaxResource($this->taxRepository->navigate($tax->id, $request->case));
            return $tax->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->taxRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    private function taxCountrySync($model, $data, $uniqueColumns, $tableName)
    {
        $insertData = collect($data)->map(function ($item) use ($model, $uniqueColumns, $tableName) {
            $item[$uniqueColumns[0]] = $model->id;
            $decision = DB::table($tableName)
                ->where($uniqueColumns[0], $model->id)
                ->get();

            if (count($decision) > 0) {

                DB::table($tableName)
                    ->where($uniqueColumns[0], $model->id)
                    ->delete();
            }

            return $item;
        })->toArray();

        DB::table($tableName)->insert($insertData);
    }


    public function getNames()
    {
        try {
            $taxesNames = NameResource::collection($this->taxRepository->names());
            return $taxesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
