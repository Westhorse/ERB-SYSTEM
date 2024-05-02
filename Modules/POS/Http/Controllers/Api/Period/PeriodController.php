<?php

namespace Modules\POS\Http\Controllers\Api\Period;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Modules\POS\Entities\Api\Period\Period;
use Modules\POS\Http\Requests\Api\Period\PeriodStoreRequest;
use Modules\POS\Http\Requests\Api\Period\PeriodUpdateRequest;
use Modules\POS\Repositories\IRepositories\IPeriod\IPeriodRepository;
use Modules\POS\Transformers\Api\Period\PeriodResource;

class PeriodController extends Controller
{
    public function __construct(private IPeriodRepository $periodRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function index()
    {
        try {
            $periods = PeriodResource::collection($this->periodRepository->all());
            return $periods->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function store(PeriodStoreRequest $request)
    {

        try {
            $model = $this->periodRepository->create($request->validated());
            $period = new PeriodResource($model);
            return $period->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Period $period
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function show(Period $period)
    {
        try {
            $period = new PeriodResource($period);
            return $period->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Period $period
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function update(Period $period, PeriodUpdateRequest $request)
    {
        try {
            $this->periodRepository->update($request->validated(), $period->id);

            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Period $period
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->periodRepository->deleteRecords('pos_periods', $request['ids']);
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
     * @param Period $period , case of navigation
     * @return object
     * @auth M.Mukhtar
     */
    public function navigate(Request $request, Period $period)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $period = new PeriodResource($this->periodRepository->navigate($period->id, $request->case, 'type', $request->type));
            return $period->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->periodRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->periodRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $periodNames = NameResource::collection($this->periodRepository->names(['id', 'name']));
            return $periodNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



}
