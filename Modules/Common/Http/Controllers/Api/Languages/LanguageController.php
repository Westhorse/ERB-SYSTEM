<?php

namespace Modules\Common\Http\Controllers\Api\Languages;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Common\Entities\Api\Languages\Language;
use Modules\Common\Http\Requests\Api\Languages\LanguageRequest;
use Modules\Common\Repositories\IRepositories\Languages\ILanguageRepository;
use Modules\Common\Transformers\Api\Languages\LanguageResource;

class LanguageController extends Controller
{

    public function __construct(private ILanguageRepository $languageRepository)
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
            $languages = LanguageResource::collection($this->languageRepository->all());
            return $languages->additional(JsonResponse::success());
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
    public function store(LanguageRequest $request)
    {
        try {
            $model = $this->languageRepository->create($request->validated());
            $language = new LanguageResource($model);
            return $language->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Language $language
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Language $systemLanguage)
    {
        try {
            $language = new LanguageResource($systemLanguage);
            return $language->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Language $system_language
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Language $systemLanguage, LanguageRequest $request)
    {
        try {
            $this->languageRepository->update($request->validated(), $systemLanguage->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Language $system_language
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->languageRepository->deleteRecords('c_languages', $request['ids']);
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
     * @param Language $Language , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Language $systemLanguage)
    {
        try {

            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $language = new LanguageResource($this->languageRepository->navigate($systemLanguage->id, $request->case));
            return $language->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->languageRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function switchLocale($lang)
    {
        app()->setlocale($lang);
        return response(['lang' => app()->getLocale(), 'status' => true], 200);
    }
}
