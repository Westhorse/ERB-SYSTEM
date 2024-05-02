<?php

namespace Modules\POS\Http\Controllers\Api\Member;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\NameResource;
use Illuminate\Support\Facades\DB;
use Modules\POS\Entities\Api\Member\Member;
use Modules\POS\Http\Requests\Api\Member\MemberRequest;
use Modules\POS\Repositories\IRepositories\Member\IMemberRepository;
use Modules\POS\Transformers\Api\Member\MemberResource;


class MemberController extends Controller
{
    public function __construct(private IMemberRepository $memberRepository)
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
            $members = MemberResource::collection($this->memberRepository->all());
            return $members->additional(JsonResponse::success());
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
    public function store(MemberRequest $request)
    {
        try {
            $model = $this->memberRepository->create($request->validated());
            $member = new MemberResource($model);
            return $member->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param member $member
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function show(Member $member)
    {
        try {
            $member = new MemberResource($member);
            return $member->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param member $member
     * @return \Illuminate\Http\Response
     * @auth M.Mukhtar
     */
    public function update(Member $member, MemberRequest $request)
    {
        try {
            $this->memberRepository->update($request->all(), $member->id);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param member $member
    //  * @return \Illuminate\Http\Response
    //  * @auth M.Mukhtar
    //  */
    public function destroy(Request $request)
    {
        try {
            $count = $this->memberRepository->deleteRecords('pos_members', $request['ids']);
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
     * @param member $member , case of navigation
     * @return object
     * @auth M.Mukhtar
     */
    public function navigate(Request $request, Member $member)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $member = new MemberResource($this->memberRepository->navigate($member->id, $request->case, 'type', $request->type));
            return $member->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getCode(Request $request)
    {
        try {
            return JsonResponse::respondSuccess('success', $this->memberRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNationalities()
    {
        try {
            // $nationalities = $this->nationalityService->getNationalities();

            // return $nationalities;
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->memberRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getNames()
    {
        try {
            $membersNames = NameResource::collection($this->memberRepository->names());
            return $membersNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
