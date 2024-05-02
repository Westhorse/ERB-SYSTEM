<?php

namespace Modules\Common\Http\Controllers\Api\Area;

use Modules\Common\Transformers\Api\Area\Branch\BranchResource;
use Illuminate\Http\Request;
use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\NameResource;
use Modules\Common\Entities\Api\Area\Branch;
use Modules\Common\Http\Requests\Api\Area\BranchRequest;
use Modules\Common\Repositories\IRepositories\Area\IBranchRepository;
use Modules\Common\Transformers\Api\Area\Branch\BranchNameResource;

class BranchController extends Controller
{

    public function __construct(private IBranchRepository $branchRepository)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     *
     */
    public function index()
    {
        try {
            $branches = BranchResource::collection($this->branchRepository->all(['region', 'business']));
            return $branches->additional(JsonResponse::success());
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
    public function store(BranchRequest $request)
    {
        try {
            $model = $this->branchRepository->create($request->except('business'));
            $model->business()->sync($request->business);
            $branch = new BranchResource($model);
            return $branch->additional(JsonResponse::savedSuccessfully());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Branch $branch
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function show(Branch $branch)
    {
        try {
            $branch = new BranchResource($branch->load('region', 'business'));
            return $branch->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function getBusiness(Branch $branch)
    {
        $branch =  new BranchNameResource($branch->load('business:id,name'));
        return $branch;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Branch $branch
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function update(Branch $branch, BranchRequest $request)
    {
        try {
            $branch->update($request->except('business'));
            $branch->business()->sync($request->business);
            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Branch $branch
     * @return \Illuminate\Http\Response
     * @auth A.Soliman
     */
    public function destroy(Request $request)
    {
        try {
            $count = $this->branchRepository->deleteRecords('c_branches', $request['ids']);
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
     * @param Branch $branch , case of navigation
     * @return object
     * @auth A.Soliman
     */
    public function navigate(Request $request, Branch $branch)
    {
        try {
            if (!in_array($request->case, ['previous', 'next', 'first', 'last']))
                return JsonResponse::respondError('The Navigate case should be one of previous,next,first,last', 422);
            $branch = new BranchResource($this->branchRepository->navigate($branch->id, $request->case, 'type', $request->type));
            return $branch->additional(JsonResponse::success());
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
            return JsonResponse::respondSuccess('success', $this->branchRepository->codeGenerator());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    public function getNames()
    {
        try {
            $branchesNames = NameResource::collection($this->branchRepository->names());
            return $branchesNames->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    public function latestId()
    {
        try {
            return array_merge(['data' => ['id' => $this->branchRepository->latestId()]], JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }
}
