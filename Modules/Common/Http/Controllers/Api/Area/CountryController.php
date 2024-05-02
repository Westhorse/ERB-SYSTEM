<?php

namespace Modules\Common\Http\Controllers\Api\Area;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Area\Country;
use Modules\Common\Http\Requests\Api\Area\CountryRequest;
use Modules\Common\Repositories\IRepositories\Area\ICountryRepository;
use Modules\Common\Transformers\Api\Area\CountryResource;
use App\Http\Resources;
use App\Http\Resources\NameResource;

class CountryController extends Controller
{

    public function __construct(private ICountryRepository $countryRepository)
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
            $countries = CountryResource::collection($this->countryRepository->all());
            return $countries->additional(JsonResponse::success());
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
    public function store(CountryRequest $request)
    {
        try {
            $model = $this->countryRepository->create($request->all());
            $country = new CountryResource($model);
            return $country->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Country $country
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Country $country)
    {
        try {
            $country = new CountryResource($country);
            return $country->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Country $country
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Country $country, CountryRequest $request)
    {
        try {
            $this->countryRepository->update($request->validated(), $country->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Country $country
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->countryRepository->deleteRecords('c_countries', $request['ids']);
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
     * @param Country $country , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Country $country)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $country = new CountryResource($this->countryRepository->navigate($country->id, $request->case));
            return $country->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Code Generator.
     *
     * @param Null
     * @return object
     * @auth A.Soliman
     */
    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->countryRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $countriesNames = NameResource::collection($this->countryRepository->names());
            return $countriesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->countryRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
