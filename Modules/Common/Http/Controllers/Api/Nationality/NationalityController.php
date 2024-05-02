<?php

namespace Modules\Common\Http\Controllers\Api\Nationality;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Nationality\Nationality;
use Modules\Common\Http\Requests\Api\Nationality\NationalityRequest;
use Modules\Common\Repositories\IRepositories\Nationality\INationalityRepository;
use App\Http\Resources;
use App\Http\Resources\NameResource;
use Modules\Common\Transformers\Api\Nationality\NationalityNameResource;
use Modules\Common\Transformers\Api\Nationality\NationalityResource;

class NationalityController extends Controller
{
    
    public function __construct(private INationalityRepository $nationalityRepository)
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
            $nationalities = NationalityResource::collection($this->nationalityRepository->all($with = []));
            return $nationalities->additional(JsonResponse::success());
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
    public function store(NationalityRequest $request)
    {
        try {
            $model = $this->nationalityRepository->create($request->all());
            $nationality = new NationalityResource($model);
            return $nationality->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Nationality $nationality)
    {
        try {
            $nationality = new NationalityResource($nationality);
            return $nationality->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(NationalityRequest $request, Nationality $nationality)
    {
        try {
            $this->nationalityRepository->update($request->validated(), $nationality->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->nationalityRepository->deleteRecords('c_nationalities', $request['ids']);
            return $count > 1 
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted")) 
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted")) 
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));    
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function navigate(Request $request, Nationality $nationality)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tag = new NationalityResource($this->nationalityRepository->navigate($nationality->id, $request->case));
            return $tag->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->nationalityRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function nationalityName(Nationality $nationality)
    {
        return JsonResponse::respondSuccess('success', new NationalityNameResource($nationality));
    }

    public function getNames()
    {
        try {
            $nationalitiesNames = NameResource::collection($this->nationalityRepository->names());
            return $nationalitiesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->nationalityRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
