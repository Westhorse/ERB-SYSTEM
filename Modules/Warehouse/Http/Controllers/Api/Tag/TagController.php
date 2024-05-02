<?php

namespace Modules\Warehouse\Http\Controllers\Api\Tag;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use  Modules\Warehouse\Entities\Api\Tag\Tag;
use Modules\Warehouse\Http\Requests\Api\Tag\TagRequest;
use Modules\Warehouse\Repositories\IRepositories\Tag\ITagRepository;
use Modules\Warehouse\Transformers\Api\Tag\TagNameResource;
use Modules\Warehouse\Transformers\Api\Tag\TagResource;

class TagController extends Controller
{

    public function __construct(private ITagRepository $tagRepository)
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
            $tags = TagResource::collection($this->tagRepository->all());
            return $tags->additional(JsonResponse::success());
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
    public function store(TagRequest $request)
    {
        try {
            $model = $this->tagRepository->create($request->validated());
            $tag   = new TagResource($model);
            return $tag->additional(JsonResponse::savedSuccessfully());
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
    public function show(Tag $tag)
    {
        try {
            $tag = new TagResource($tag);
            return $tag->additional(JsonResponse::success());
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
    public function update(TagRequest $request, Tag $tag)
    {
        try {
            $this->tagRepository->update($request->validated(), $tag->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY));
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
            $count = $this->tagRepository->deleteRecords('w_tags', $request['ids']);
            return $count > 1
            ? JsonResponse::respondError(trans("responses.msg_multi_resources_cannot_deleted"))
            : ($count == 1 ? JsonResponse::respondError(trans("responses.msg_cannot_deleted"))
            : JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY)));
        } catch(\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }


    }

    public function navigate(Request $request, Tag $tag)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $tag = new TagResource($this->tagRepository->navigate($tag->id, $request->case));
            return $tag->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->tagRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }

    }

    public function tagName(Tag $tag)
    {
        $tag = new TagNameResource($tag);
        return JsonResponse::respondSuccess('success', $tag);
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->tagRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

}
