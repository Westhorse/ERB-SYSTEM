<?php

namespace Modules\Common\Http\Controllers\Api\Currency;

use App\Http\Controllers\Controller;
use App\Helpers\JsonResponse;
use Modules\Common\Transformers\Api\Currency\CurrencyPartsResource;
use Modules\Common\Transformers\Api\Currency\CurrencyExResource;
use Modules\Common\Transformers\Api\Currency\CurrencyResource;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Modules\Common\Entities\Api\Currency\Currency;
use Modules\Common\Entities\Api\Currency\CurrencyExchange;
use Modules\Common\Http\Requests\Api\Currency\CurrencyRequest;
use Modules\Common\Repositories\IRepositories\Currency\ICurrencyRepository;
use Modules\Common\Rules\CustomDistinctArray;

class CurrencyController extends Controller
{

    public function __construct(private ICurrencyRepository $currencyRepository)
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
            $currencies = CurrencyResource::collection($this->currencyRepository->all($with = ['currencyExchange', 'currencyPart']));
            return $currencies->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $currenciesNames = NameResource::collection($this->currencyRepository->names());
            return $currenciesNames->additional(JsonResponse::success());
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

    public function store(CurrencyRequest $request)
    {
        try {
            $model = $this->currencyRepository->create($request->validated());

            if ($request->parts) $model->currencyPart()->createMany($request->parts);
            if ($request->exchanges) $model->currencyExchange()->createMany($request->exchanges);
            $currency = new CurrencyResource($model);
            // if ($request->exchanges)
            //     foreach ($request->exchanges as $data) {
            //         insertExchange($model->id, $data['to_currency_id'], $data['exchange_date'], $data['exchange_rate']);
            //     }
            return $currency->additional(JsonResponse::savedSuccessfully());
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
    public function show(Currency $currency)
    {
        try {
            $currency = new CurrencyResource($currency->load('currencyExchange', 'currencyPart'));
            return $currency->additional(JsonResponse::success());
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
    public function update(CurrencyRequest $request, Currency $currency)
    {
        try {
            $data = $request->except('currencyExchange', 'currencyPart');
            $currency->update($data);


            $currency->currencyExchange()->delete();

            if (!empty($request->exchanges)) {
                $currencyExchange = $request->exchanges;
                foreach ($currencyExchange as $Part) {
                    $currency->currencyExchange()->updateOrCreate(
                        [
                            'id' => (isset($Part['id']) ? $Part['id'] : null)
                        ],
                        $Part
                    );
                }
            }


            $currency->currencyPart()->delete();

            if (!empty($request->parts)) {
                $currencyPart = $request->parts;
                foreach ($currencyPart as $Part) {
                    $currency->currencyPart()->updateOrCreate(
                        [
                            'id' => (isset($Part['id']) ? $Part['id'] : null)
                        ],
                        $Part
                    );
                }
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }


    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->currencyRepository->latestId()]], JsonResponse::success());
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
            if (checkColumnUsed($databaseName, 'c_currencies', 'id', $id, ['c_currencies_exchange', 'c_currencies_parts'])) {
                $destroyDenied[] = [$id];
            } else {
                DB::delete('delete from c_currencies_exchange where from_currency_id  = ?', [$id]);
                DB::delete('delete from c_currencies_exchange where to_currency_id  = ?', [$id]);
                DB::delete('delete from c_currencies_parts where currency_id = ?', [$id]);
                $this->currencyRepository->delete($id);
            }
        }
        if (count($destroyDenied) == 1) {
            return JsonResponse::respondError(trans("responses.msg_cannot_deleted"));
        } elseif (count($destroyDenied) > 1) {
            return JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"));
        }
        return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
    }

    public function navigate(Request $request, Currency $currency)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $currency = new CurrencyResource($this->currencyRepository->navigate($currency->id, $request->case, 'vtype', $request->vtype));
            return $currency->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    // public function getExchange(Currency $currency, Request $request)
    // {
    //     // try {
    //     $exchangeRate = new CurrencyExResource($currency->with(['currencyExchange' => function ($query) use ($request) {
    //         $query->where([
    //             ["from_currency_id", "=", $request["from_currency_id"]],
    //             ["to_currency_id", "=",  $request["to_currency_id"]],
    //             ["exchange_date", "=", $request["exchange_date"]],
    //         ]);
    //     }])->first());
    //     // exchange_rate
    //     return $exchangeRate;

    //     //     return $product->additional(JsonResponse::success());
    //     // } catch (\Exception $e) {
    //     //     return JsonResponse::respondError($e->getMessage());
    //     // }
    // }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->currencyRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCurrencyParts($currencyId)
    {
        try {
            $currency = Currency::findOrFail($currencyId);
            if ($currency) {
                $currencyParts = CurrencyPartsResource::collection($this->currencyRepository->currencyParts($currency->id));
                return $currencyParts->additional(JsonResponse::success());
            }
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
