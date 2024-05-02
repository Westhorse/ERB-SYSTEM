<?php

namespace Modules\Common\Http\Controllers\Api\Vehicle;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Modules\Common\Transformers\Api\Vehicle\VehicleTypeResource;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Common\Entities\Api\Vehicle\VehicleType;
use Modules\Common\Http\Requests\Api\Vehicle\VehicleTypeRequest;
use Modules\Common\Repositories\IRepositories\Vehicle\IVehicleTypeRepository;

class VehicleTypeController extends Controller
{

    public function __construct(private IVehicleTypeRepository $vehicleTypeRepository)
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
            $vehicleTypes = VehicleTypeResource::collection($this->vehicleTypeRepository->getAllByType($request->vtype));
            return $vehicleTypes->additional(JsonResponse::success());
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
    public function store(VehicleTypeRequest $request)
    {
        try {
            $model = $this->vehicleTypeRepository->create($request->validated());
            $vehicleType = new VehicleTypeResource($model);
            return $vehicleType->additional(JsonResponse::savedSuccessfully());
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
    public function show(VehicleType $vehicleType)
    {
        try {
            $vehicleType = new VehicleTypeResource($vehicleType);
            return $vehicleType->additional(JsonResponse::success());
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
    public function update(VehicleTypeRequest $request, VehicleType $vehicleType)
    {
        try {
            $this->vehicleTypeRepository->update($request->validated(), $vehicleType->id);
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
            $count = $this->vehicleTypeRepository->deleteRecords('c_vehicle_types', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function navigate(Request $request,VehicleType $vehicleType)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
                $vehicleType= new VehicleTypeResource($this->vehicleTypeRepository->navigate($vehicleType->id, $request->case, 'vtype', $request->vtype));
            return $vehicleType->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->vehicleTypeRepository->codeGenerator('vtype', $request['vtype']));
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function export()
    {
        return Excel::download(new VehicleTypeExport, 'users.xlsx');
        // return Excel::download( new VehicleTypeExport, 'export.csv', \Maatwebsite\Excel\Excel::CSV, [ 'Content-Type' => 'text/csv', ] );
    }


    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->vehicleTypeRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
