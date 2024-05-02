<?php

namespace Modules\FixedAsset\Http\Controllers\Api\AssetTransfer;

use App\Helpers\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Modules\FixedAsset\Entities\Api\AssetTransfer\AssetTransfer;
use Modules\FixedAsset\Http\Requests\Api\AssetTransfer\AssetStatusRequest;
use Modules\FixedAsset\Repositories\IRepositories\IAssetTransfer\IAssetTransferRepository;
use Modules\FixedAsset\Transformers\Api\AssetTransfer\AssetTransferResource;

class AssetTransferController extends Controller
{
    public function __construct(private IAssetTransferRepository $AssetTransferRepository)
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
            $AssetTransfer = AssetTransferResource::collection($this->AssetTransferRepository->all($with = ['tempUsers']));
            return $AssetTransfer->additional(JsonResponse::success());
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
    public function store(AssetStatusRequest $request)
    {
        try {
            if (empty($request["current_status_id"] and $request["current_deprecation_account_id"] and $request["current_cost_center_id"])) {
                $modelee =  DB::table('w_products')->where("id", "=", $request["product_id"])->first();
                $asset_status = $modelee->asset_status_id;
                $deprecation_account = $modelee->deprecation_account_id;
                $cost_account  = $modelee->cost_account_id;

                if ($request["current_status_id"] === null) {
                    DB::table('w_products')->where("id", "=", $request["product_id"])
                        ->update([
                            "asset_status_id" => $asset_status,
                            "deprecation_account_id" => $request["current_deprecation_account_id"],
                            "cost_center_id" => $request["current_cost_center_id"],
                        ]);
                    $model      = $this->AssetTransferRepository->create($request->validated());
                    $AssetTransfer  = new AssetTransferResource($model);
                    return $AssetTransfer->additional(JsonResponse::savedSuccessfully());
                } elseif ($request["current_deprecation_account_id"] === null) {
                    DB::table('w_products')->where("id", "=", $request["product_id"])
                        ->update([
                            "asset_status_id" => $request["current_status_id"],
                            "deprecation_account_id" => $deprecation_account,
                            "cost_center_id" => $request["current_cost_center_id"],
                        ]);
                    $model      = $this->AssetTransferRepository->create($request->validated());
                    $AssetTransfer  = new AssetTransferResource($model);
                    return $AssetTransfer->additional(JsonResponse::savedSuccessfully());
                } elseif ($request["current_cost_center_id"] === null) {
                    DB::table('w_products')->where("id", "=", $request["product_id"])
                        ->update([
                            "asset_status_id" => $request["current_status_id"],
                            "deprecation_account_id" => $request["current_deprecation_account_id"],
                            "cost_center_id" => $cost_account,
                        ]);
                    $model      = $this->AssetTransferRepository->create($request->validated());
                    $AssetTransfer  = new AssetTransferResource($model);
                    return $AssetTransfer->additional(JsonResponse::savedSuccessfully());
                }
            } else {
                DB::table('w_products')->where("id", "=", $request["product_id"])
                    ->update([
                        "asset_status_id" => $request["current_status_id"],
                        "deprecation_account_id" => $request["current_deprecation_account_id"],
                        "cost_center_id" => $request["current_cost_center_id"],
                    ]);
                $model      = $this->AssetTransferRepository->create($request->validated());
                $AssetTransfer  = new AssetTransferResource($model);
                return $AssetTransfer->additional(JsonResponse::savedSuccessfully());
            }
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AssetTransfer\AssetTransfer  $assetTransfer
     * @return \Illuminate\Http\Response
     */
    public function show(AssetTransfer $assetTransfer)
    {
        try {
            $assetTransfer = new AssetTransferResource($assetTransfer);
            return $assetTransfer->additional(JsonResponse::success());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }



    public function getOrderNumper()
    {
        try {
            return JsonResponse::respondSuccess('success', $this->AssetTransferRepository->orderNumperNext());
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }




    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AssetTransfer\AssetTransfer  $assetTransfer
     * @return \Illuminate\Http\Response
     */
    public function update(AssetTransfer $assetTransfer, AssetStatusRequest $request)
    {
        try {

            $id =  $assetTransfer->id;
            DB::table('w_products')->where("id", "=", $request["product_id"])
                ->update([
                    "asset_status_id" => $request["old_status_id"],
                    "deprecation_account_id" => $request["old_deprecation_account_id"],
                    "cost_center_id" => $request["old_cost_center_id"],
                    "asset_status_id" => $request["current_status_id"],
                    "deprecation_account_id" => $request["current_deprecation_account_id"],
                    "cost_center_id" => $request["current_cost_center_id"],
                ]);

            DB::table('f_asset_transfer')->where("id", "=", $id)->update([
                "order_number" => $request["order_number"],
                "product_id" => $request["product_id"],
                "order_date" => $request["order_date"],
                "user_id" => $request["user_id"],
                "current_status_id" => $request["current_status_id"],
                "current_cost_center_id" => $request["current_cost_center_id"],
                "current_deprecation_account_id" => $request["current_deprecation_account_id"],
            ]);

            return JsonResponse::respondSuccess(trans(JsonResponse::MSG_UPDATED_SUCCESSFULLY), null);
        } catch (\Exception $e) {
            return JsonResponse::respondError($e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AssetTransfer\AssetTransfer  $assetTransfer
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        foreach ($request["ids"] as $id) {
            $asset_row = DB::table('f_asset_transfer')->where('id', "=", $id)->first();
            $product_id = $asset_row->product_id;
            $maxId = DB::table('f_asset_transfer')->where('product_id', "=", $product_id)->where('deleted_at', "=", null)->max('id');
            if ($id < $maxId) {
                return JsonResponse::respondError(trans("you can not delete"));
            } else {
                AssetTransfer::where('id', "=", $id)->delete();
                $current_status = $asset_row->old_status_id;
                $current_deprecation = $asset_row->old_deprecation_account_id;
                $current_cost_center = $asset_row->old_cost_center_id;

                DB::table('w_products')->where("id", "=", $product_id)
                    ->update([
                        "asset_status_id" => $current_status,
                        "deprecation_account_id" => $current_deprecation,
                        "cost_center_id" => $current_cost_center,
                    ]);
                return JsonResponse::respondSuccess(trans(JsonResponse::MSG_DELETED_SUCCESSFULLY));
            }
        }
    }
}
