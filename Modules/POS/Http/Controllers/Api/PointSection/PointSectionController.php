<?php

namespace Modules\POS\Http\Controllers\Api\PointSection;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;

use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Setting\Setting;
use Modules\POS\Entities\Api\PointSection\PointSection;
use Modules\POS\Http\Requests\Api\PointSection\PointSectionUpdateRequest;
use Modules\POS\Repositories\IRepositories\IPointSection\IPointSectionRepository;
use Modules\POS\Transformers\Api\PointSection\PointSectionResource;

class PointSectionController extends Controller
{

    public function __construct(private IPointSectionRepository $pointSectionRepository)
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
            $points = new PointSectionResource($this->pointSectionRepository->getPointSectionsAndSettingValue());
            return $points->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(PointSectionUpdateRequest $request)
    {
        try {
            if (isset($request['deletedIds'])) {
                $ids = $request['deletedIds'];
                foreach ($ids as $id) {
                    DB::table('pos_points_sections')->delete($id);
                }
            }
            Setting::where('setting_id', 4001)->update(['setting_value' => $request['pointValue'] ?? Null]);
            foreach ($request->value as $data) {
                $x = collect($data)->except('pointValue');

                $model[] = PointSection::updateOrCreate(
                    [
                        'id' => (isset($x['id']) ?  $x['id'] : null)
                    ],
                    [
                        'section_from' => $x['section_from'],
                        'section_to' => $x['section_to'],
                        'point_value' => $x['point_value'],
                    ]
                );
            }
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
            // $point_section = PointSectionResource::collection($model);
            // return $point_section->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PointSection  $pointSection
     * @return \Illuminate\Http\Response
     */
    public function show(PointSection $pointSection)
    {
        try {
            $pointSection = new PointSectionResource($pointSection);
            return $pointSection->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PointSection  $pointSection
     * @return \Illuminate\Http\Response
     */
    // public function update(PointSectionUpdateRequest $request, PointSection $pointSection)
    // {
    //     try {
    //         // $this->pointSectionRepository->update($request->all(), $pointSection->id);

    //         foreach ($request->value as $data) {
    //             PointSection::updateOrCreate(
    //                 [
    //                     'id' => (isset($data['id']) ? $data['id'] : null)
    //                 ],
    //                 $data
    //             );
    //         }
    //         return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
    //     } catch (\Exception $e) {
    //         return JsonResponse::respondError($e->getMessage());
    //     }
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PointSection  $pointSection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $databaseName = DB::connection()->getDatabaseName();
        $destroy_denied = [];
        foreach ($request->ids as $id) {
            if (checkColumnUsed($databaseName, 'pos_points_sections', 'id', $id)) {
                $destroy_denied[] = [$id];
            } else {
                $this->pointSectionRepository->delete($id);
            }
        }
        if (count($destroy_denied) == 1) {
            return JsonResponse::respondError(trans("responses.msg_cannot_deleted"));
        } elseif (count($destroy_denied) > 1) {
            return JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"));
        }
        return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
    }

    public function navigate(Request $request, PointSection $pointSection)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $pointSection = new PointSectionResource($this->pointSectionRepository->navigate($pointSection->id, $request->case, 'type', $request->type));
            return $pointSection->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
