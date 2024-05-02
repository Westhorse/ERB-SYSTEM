<?php

namespace Modules\Common\Http\Controllers\Api\Vehicle;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Vehicle\VehicleDataResource;
use Modules\Common\Transformers\Api\Vehicle\VehicleWheelResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Vehicle\VehicleData;
use Modules\Common\Http\Requests\Api\Vehicle\VehicleDataRequest;
use Modules\Common\Repositories\IRepositories\Vehicle\IVehicleDataRepository;

class VehicleDataController extends Controller
{

    public function __construct(private IVehicleDataRepository $vehicleDataRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function index(Request $request)
    {
        try {
            $vehicleData = VehicleDataResource::collection($this->vehicleDataRepository->getAllByType($request->vtype));
            return $vehicleData->additional(JsonResponse::success());
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
    public function store(VehicleDataRequest $request)
    {
        try {
            $model = $this->vehicleDataRepository->create($request->except('cards'));
            if ($request->cards) $model->VehicleDocument()->createMany($request->cards);
            $vehicleData = new VehicleDataResource($model);
            return $vehicleData->additional(JsonResponse::savedSuccessfully());
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
    public function show(VehicleData $vehicle_datum)
    {
        try {
            $vehicleData = new VehicleDataResource($vehicle_datum);
            return $vehicleData->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function latestId()
    {

        try {
            return array_merge(['data' => ['id' => $this->vehicleDataRepository->latestId()]], JsonResponse::success());
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
    public function update(VehicleDataRequest $request, VehicleData $vehicle_datum)
    {
        try {
            $data = $request->except('cards');
            $vehicle_datum->update($data);

            // $this->vehicleDataRepository->update($data, $vehicleData->id);
            if (!empty($request->cards)) {
                foreach ($request->cards as $data) {
                    $vehicle_datum->VehicleDocument()->updateOrCreate(
                        [
                            'id' => (isset($data['id']) ? $data['id'] : null)
                        ],
                        $data
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
     * @param Example $example
     * @return \Illuminate\Http\Response
     * @auth Developer
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->vehicleDataRepository->deleteRecords('c_vehicle_data', $request['ids']);
            return $count > 1
                ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
                : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
                    : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, VehicleData $vehicleData)
    {

        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $vehicleData = new VehicleDataResource($this->vehicleDataRepository->navigate($vehicleData->id, $request->case, 'vtype', $request->vtype));
            return $vehicleData->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->vehicleDataRepository->codeGenerator('vtype', $request['vtype']));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCover(Request $request)
    {


        try {


            $covers = DB::select('SELECT * from c_v_vehicle_wheels
            WHERE vehicle_id = ' . "$request->vehicle_id " . '');


            return response(VehicleWheelResource::collection($covers), 200);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
