<?php

use Illuminate\Support\Facades\Route;
use Modules\FixedAsset\Http\Controllers\Api\AssetGroup\FixedAssetGroupController;
use Modules\FixedAsset\Http\Controllers\Api\AssetStatus\AssetStatusController;
use Modules\FixedAsset\Http\Controllers\Api\AssetTransfer\AssetTransferController;

// Route::apiResource('examples', 'ExampleController');
// Route::post('examples/navigation/{example}', [ExampleController::class, 'navigate']);

//==========================================API's=================================================

Route::group(['middleware' => ['Language']], function () {

    Route::get('languages/{lang}', [\App\Http\Controllers\LanguageController::class, 'update']);

    // Asset Group
    Route::get('asset-groups/latest-id', [FixedAssetGroupController::class, 'latestId']);
    Route::post('asset-groups/index', [FixedAssetGroupController::class, 'index']);
    Route::delete('asset-groups/delete', [FixedAssetGroupController::class, 'destroy']);
    Route::post('asset-groups/code', [FixedAssetGroupController::class, 'getCode']);
    Route::post('asset-groups/navigation/{asset_group}', [FixedAssetGroupController::class, 'navigate']);
    Route::apiResource('asset-groups', FixedAssetGroupController::class);

    // Asset Status
    Route::get('asset-status/latest-id', [AssetStatusController::class, 'latestId']);
    Route::post('asset-status/index', [AssetStatusController::class, 'index']);
    Route::delete('asset-status/delete', [AssetStatusController::class, 'destroy']);
    Route::post('asset-status/code', [AssetStatusController::class, 'getCode']);
    Route::post('asset-status/navigation/{asset_status}', [AssetStatusController::class, 'navigate']);
    Route::get('asset-status/names', [AssetStatusController::class, 'getNames']);
    Route::apiResource('asset-status', AssetStatusController::class);

    // Transfer
    Route::post('asset-transfers/index', [AssetTransferController::class, 'index']);
    Route::delete('asset-transfers/delete', [AssetTransferController::class, 'delete']);
    Route::patch('asset-transfers/{asset_transfer}', [AssetTransferController::class, 'update']);
    Route::post('asset-transfers/order-numper', [AssetTransferController::class, 'getOrderNumper']);
    Route::apiResource('asset-transfers', AssetTransferController::class);
});
