<?php

use App\Http\Controllers\LanguageController;
use Illuminate\Support\Facades\Route;
use Modules\POS\Http\Controllers\Api\Account\AccountController;
use Modules\POS\Http\Controllers\Api\Cashier\CashierController;
use Modules\POS\Http\Controllers\Api\CashTransfer\CashTransferController;
use Modules\POS\Http\Controllers\Api\Member\MemberController;
use Modules\POS\Http\Controllers\Api\Period\PeriodController;
use Modules\POS\Http\Controllers\Api\PointSection\PointSectionController;

Route::group(['middleware' => ['Language']], function () {
    Route::get('languages/{lang}', [LanguageController::class, 'update']);

    // Cashier
    Route::get('cashiers/latest-id', [CashierController::class, 'latestId']);
    Route::get('cashiers/names', [CashierController::class, 'getNames']);
    Route::delete('cashiers/delete', [CashierController::class, 'destroy']);
    Route::post('cashiers/index', [CashierController::class, 'index']);
    Route::post('cashiers/navigation/{cashier}', [CashierController::class, 'navigate']);
    Route::post('cashiers/code', [CashierController::class, 'getCode']);
    Route::apiResource('cashiers', CashierController::class);

    // Period
    Route::get('periods/latest-id', [PeriodController::class, 'latestId']);
    Route::get('periods/names', [PeriodController::class, 'getNames']);
    Route::delete('periods/delete', [PeriodController::class, 'destroy']);
    Route::post('periods/index', [PeriodController::class, 'index']);
    Route::post('periods/navigation/{period}', [PeriodController::class, 'navigate']);
    Route::post('periods/code', [PeriodController::class, 'getCode']);
    Route::apiResource('periods', PeriodController::class);

    // Member
    Route::get('members/latest-id', [MemberController::class, 'latestId']);
    Route::get('members/names', [MemberController::class, 'getNames']);
    Route::post('members/index', [MemberController::class, 'index']);
    Route::delete('members/delete', [MemberController::class, 'destroy']);
    Route::post('members/navigation/{member}', [MemberController::class, 'navigate']);
    Route::post('members/code', [MemberController::class, 'getCode']);
    Route::get('members/nationalities', [MemberController::class, 'getNationalities']);
    Route::apiResource('members', MemberController::class);

    // Point section
    Route::post('point-sections/index', [PointSectionController::class, 'index']);
    Route::delete('point-sections/delete', [PointSectionController::class, 'destroy']);
    Route::patch('point-sections/update', [PointSectionController::class, 'update']);
    Route::post('point-sections/navigation/{pointSection}', [PointSectionController::class, 'navigate']);
    Route::apiResource('point-sections', PointSectionController::class);

    // Cash Transfer
    Route::get('cash-transfers/latest-id', [CashTransferController::class, 'latestId']);
    Route::post('cash-transfers/index', [CashTransferController::class, 'index']);
    Route::delete('cash-transfers/delete', [CashTransferController::class, 'destroy']);
    Route::post('cash-transfers/navigation/{cashTransfer}', [CashTransferController::class, 'navigate']);
    Route::apiResource('cash-transfers', CashTransferController::class);
});
