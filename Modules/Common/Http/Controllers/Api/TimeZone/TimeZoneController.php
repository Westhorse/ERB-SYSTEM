<?php

namespace Modules\Common\Http\Controllers\Api\TimeZone;

use App\Http\Controllers\Controller;
use App\Helpers\JsonResponse;
use Modules\Common\Repositories\IRepositories\TimeZone\ITimeZoneRepository;
use Modules\Common\Transformers\Api\TimeZone\TimeZoneResource;

class TimeZoneController extends Controller
{

    public function __construct(private ITimeZoneRepository $timeZoneRepository)
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
            $timeZones = TimeZoneResource::collection($this->timeZoneRepository->all());
            return $timeZones->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
