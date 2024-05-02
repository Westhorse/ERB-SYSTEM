<?php

use App\Http\Controllers\TempController;
use Illuminate\Support\Facades\Route;


use Modules\Common\Http\Controllers\Api\{
    BillTypeGroup\BillTypeGroupController,
    Nationality\NationalityController,
    Card\DocumentTypeController,
    Vehicle\VehicleDataController,
    Vehicle\VehicleTypeController,
    Vehicle\WheelController,
    Area\RegionController,
    Area\CountryController,
    Area\BranchController,
    CarClassification\CarClassificationController,
    CarStatus\CarStatusController,
    DocumentIssuer\DocumentIssuerController,
    Localization\DistrictController,
    Tax\TaxController,
    Currency\CurrencyController
};
use Modules\Common\Http\Controllers\Api\Bills\BillController;
use Modules\Common\Http\Controllers\Api\BillInstallments\BillInstallmentController;
use Modules\Common\Http\Controllers\Api\Languages\LanguageController;
use Modules\Common\Http\Controllers\Api\BillType\BillTypeController;
use Modules\Common\Http\Controllers\Api\Business\BusinessController;
use Modules\Common\Http\Controllers\Api\LanguageShortcut\LanguageShortcutController;
use Modules\Common\Http\Controllers\Api\Payment\PaymentTypeController;
use Modules\Common\Http\Controllers\Api\Setting\SettingController;
use Modules\Common\Http\Controllers\Api\Translations\CaptionController;
use Modules\Common\Http\Controllers\Api\Translations\DefaultValueController;
use Modules\Common\Http\Controllers\Api\Translations\MessageController;

Route::group(['middleware' => ['Language']], function () {





    //Districts
    Route::get('districts/names', [DistrictController::class, 'getNames']);
    Route::get('districts/latest-id', [DistrictController::class, 'latestId']);
    Route::post('districts/index', [DistrictController::class, 'index']);
    Route::delete('districts/delete', [DistrictController::class, 'destroy']);
    Route::post('districts/code', [DistrictController::class, 'getCode']);
    Route::post('districts/navigation/{district}', [DistrictController::class, 'navigate']);
    Route::apiResource('districts', DistrictController::class);

    //Regions
    Route::get('regions/names', [RegionController::class, 'getNames']);
    Route::get('regions/latest-id', [RegionController::class, 'latestId']);
    Route::post('regions/index', [RegionController::class, 'index']);
    Route::delete('regions/delete', [RegionController::class, 'destroy']);
    Route::post('regions/code', [RegionController::class, 'getCode']);
    Route::post('regions/navigation/{region}', [RegionController::class, 'navigate']);
    Route::apiResource('regions', RegionController::class);


    //Countries
    Route::get('countries/names', [CountryController::class, 'getNames']);
    Route::get('countries/latest-id', [CountryController::class, 'latestId']);
    Route::post('countries/index', [CountryController::class, 'index']);
    Route::delete('countries/delete', [CountryController::class, 'destroy']);
    Route::post('countries/code', [CountryController::class, 'getCode']);
    Route::post('countries/navigation/{country}', [CountryController::class, 'navigate']);
    Route::apiResource('countries', CountryController::class);
    Route::post('currencies/{currency}/exchange', [CurrencyController::class, 'getExchange']);

    //Branches
    Route::get('branches/latest-id', [BranchController::class, 'latestId']);
    Route::get('branches/names', [BranchController::class, 'getNames']);
    Route::post('branches/index', [BranchController::class, 'index']);
    Route::delete('branches/delete', [BranchController::class, 'destroy']);
    Route::post('branches/code', [BranchController::class, 'getCode']);
    Route::post('branches/navigation/{branch}', [BranchController::class, 'navigate']);
    Route::apiResource('branches', BranchController::class);

    Route::get('branches/{branch}/business', [BranchController::class, 'getBusiness']);


    //Document Types

    Route::post('document-types/index', [DocumentTypeController::class, 'index']);
    Route::get('document-types/latest-id', [DocumentTypeController::class, 'latestId']);
    Route::delete('document-types/delete', [DocumentTypeController::class, 'destroy']);
    Route::post('document-types/code', [DocumentTypeController::class, 'getCode']);
    Route::post('document-types/navigation/{document_type}', [DocumentTypeController::class, 'navigate']);
    Route::apiResource('document-types', DocumentTypeController::class);


    //Payment Types
    Route::post('payment-types/index', [PaymentTypeController::class, 'index']);
    Route::get('payment-types/latest-id', [PaymentTypeController::class, 'latestId']);
    Route::delete('payment-types/delete', [PaymentTypeController::class, 'destroy']);
    Route::post('payment-types/code', [PaymentTypeController::class, 'getCode']);
    Route::post('payment-types/navigation/{payment_type}', [PaymentTypeController::class, 'navigate']);
    Route::apiResource('payment-types', PaymentTypeController::class);



    //Vehicle Types
    Route::post('vehicle-types/delete', [VehicleTypeController::class, 'destroy']);
    Route::get('vehicle-types/latest-id', [VehicleTypeController::class, 'latestId']);
    Route::post('vehicle-types/index', [VehicleTypeController::class, 'index']);
    Route::post('vehicle-types/code', [VehicleTypeController::class, 'getCode']);
    Route::get('vehicle-types/export', [VehicleTypeController::class, 'export']);
    Route::post('vehicle-types/navigation/{vehicle_type}', [VehicleTypeController::class, 'navigate']);
    Route::apiResource('vehicle-types', VehicleTypeController::class);

    //Wheel Types
    Route::delete('wheel-types/delete', [WheelController::class, 'destroy']);
    Route::get('wheel-types/latest-id', [WheelController::class, 'latestId']);
    Route::post('wheel-types/index', [WheelController::class, 'index']);
    Route::post('wheel-types/code', [WheelController::class, 'getCode']);
    Route::post('wheel-types/navigation/{wheel_type}', [WheelController::class, 'navigate']);
    Route::apiResource('wheel-types', WheelController::class);

    //Vehicle Data
    Route::delete('vehicle-data/delete', [VehicleDataController::class, 'destroy']);
    Route::get('vehicle-data/latest-id', [VehicleDataController::class, 'latestId']);
    Route::post('vehicle-data/index', [VehicleDataController::class, 'index']);
    Route::get('vehicle-data/get-cover', [VehicleDataController::class, 'getCover']);
    Route::post('vehicle-data/code', [VehicleDataController::class, 'getCode']);
    Route::post('vehicle-data/navigation/{vehicle_data}', [VehicleDataController::class, 'navigate']);
    Route::apiResource('vehicle-data', VehicleDataController::class);


    // timezone
    Route::get('time-zone', [\Modules\Common\Http\Controllers\Api\TimeZone\TimeZoneController::class, 'index']);

    // Language Shortcut
    Route::get('system-languages/shortcuts', [LanguageShortcutController::class, 'index']);

    //carstatus

    Route::post('car-status/index', [CarStatusController::class, 'index']);
    Route::get('car-status/latest-id', [CarStatusController::class, 'latestId']);
    Route::delete('car-status/delete', [CarStatusController::class, 'destroy']);
    Route::post('car-status/code', [CarStatusController::class, 'getCode']);
    Route::post('car-status/navigation/{car_status}', [CarStatusController::class, 'navigate']);
    Route::apiResource('car-status', CarStatusController::class);

    // document-issuer
    Route::post('document-issuer/index', [DocumentIssuerController::class, 'index']);
    Route::get('document-issuer/latest-id', [DocumentIssuerController::class, 'latestId']);
    Route::delete('document-issuer/delete', [DocumentIssuerController::class, 'destroy']);
    Route::post('document-issuer/code', [DocumentIssuerController::class, 'getCode']);
    Route::post('document-issuer/navigation/{document_issuer}', [DocumentIssuerController::class, 'navigate']);
    Route::apiResource('document-issuer', DocumentIssuerController::class);

    //car-classifications
    Route::get('car-classifications/latest-id', [CarClassificationController::class, 'latestId']);
    Route::get('car-classifications/names', [CarClassificationController::class, 'getNames']);
    Route::post('car-classifications/index', [CarClassificationController::class, 'index']);
    Route::delete('car-classifications/delete', [CarClassificationController::class, 'destroy']);
    Route::post('car-classifications/code', [CarClassificationController::class, 'getCode']);

    Route::post('car-classifications/navigation/{car_classification}', [CarClassificationController::class, 'navigate']);
    Route::apiResource('car-classifications', CarClassificationController::class);


    //currency
    Route::get('currencies/parts/{id}', [CurrencyController::class, 'getCurrencyParts']);
    Route::get('currencies/names', [CurrencyController::class, 'getNames']);
    Route::post('currencies/index', [CurrencyController::class, 'index']);
    Route::get('currencies/latest-id', [CurrencyController::class, 'latestId']);
    Route::delete('currencies/delete', [CurrencyController::class, 'destroy']);
    Route::post('currencies/code', [CurrencyController::class, 'getCode']);
    Route::post('currencies/navigation/{currency}', [CurrencyController::class, 'navigate']);
    Route::apiResource('currencies', CurrencyController::class);

    //taxes
    Route::get('taxes/names', [TaxController::class, 'getNames']);
    Route::get('taxes/latest-id', [TaxController::class, 'latestId']);
    Route::post('taxes/index', [TaxController::class, 'index']);
    Route::delete('taxes/delete', [TaxController::class, 'destroy']);
    Route::post('taxes/code', [TaxController::class, 'getCode']);
    Route::post('taxes/navigation/{tax}', [TaxController::class, 'navigate']);
    Route::apiResource('taxes', TaxController::class);


    // Nationality
    Route::get('nationalities/names', [NationalityController::class, 'getNames']);
    Route::post('nationalities/index', [NationalityController::class, 'index']);
    Route::get('nationalities/latest-id', [NationalityController::class, 'latestId']);
    Route::delete('nationalities/delete', [NationalityController::class, 'destroy']);
    Route::post('nationalities/code', [NationalityController::class, 'getCode']);
    Route::get('nationalities/nationality-name/{nationality}', [NationalityController::class, 'nationalityName']);
    Route::post('nationalities/navigation/{nationality}', [NationalityController::class, 'navigate']);
    Route::apiResource('nationalities', NationalityController::class);


    //Bill Types Groups
    Route::get('bill-types-groups/latest-id', [BillTypeGroupController::class, 'latestId']);
    Route::get('bill-types-groups/names', [BillTypeGroupController::class, 'getNames']);
    Route::post('bill-types-groups/index', [BillTypeGroupController::class, 'index']);
    Route::delete('bill-types-groups/delete', [BillTypeGroupController::class, 'destroy']);
    Route::post('bill-types-groups/code', [BillTypeGroupController::class, 'getCode']);
    Route::post('bill-types-groups/navigation/{bill_types_group}', [BillTypeGroupController::class, 'navigate']);
    Route::apiResource('bill-types-groups', BillTypeGroupController::class);

    //Bill Types
    Route::get('bill-types/latest-id', [BillTypeController::class, 'latestId']);
    Route::post('bill-types/index', [BillTypeController::class, 'index']);
    Route::get('bill-types/names', [BillTypeController::class, 'getNames']);
    Route::post('bill-types/names-with-accounts', [BillTypeController::class, 'nameObj']);
    Route::delete('bill-types/delete', [BillTypeController::class, 'destroy']);
    Route::post('bill-types/navigation/{bill_type}', [BillTypeController::class, 'navigate']);
    Route::get('bill-types/type/{typeId}', [BillTypeController::class, 'getByType']);
    Route::post('bill-types/{bill_type}/setting', [BillTypeController::class, 'getBillTypeSetting']);
    Route::apiResource('bill-types', BillTypeController::class);



    //Languages And Translations

    // switch_locale
    Route::get('languages/{lang}', [LanguageController::class, 'switchLocale']);

    // system-languages
    Route::post('system-languages/index', [LanguageController::class, 'index']);
    Route::delete('system-languages/delete', [LanguageController::class, 'destroy']);
    Route::post('system-languages/code', [LanguageController::class, 'getCode']);
    Route::post('system-languages/navigation/{system_language}', [LanguageController::class, 'navigate']);
    Route::apiResource('system-languages', LanguageController::class);

    // Default Values
    Route::post('default-values/index', [DefaultValueController::class, 'index']);
    Route::delete('default-values/delete', [DefaultValueController::class, 'destroy']);
    Route::get('default-values/code', [DefaultValueController::class, 'getCode']);
    Route::get('default-values/get-code-data/{code}', [DefaultValueController::class, 'getByCode']);
    Route::post('default-values/navigation/{default_value}', [DefaultValueController::class, 'navigate']);
    Route::apiResource('default-values', DefaultValueController::class);

    // Captions
    Route::post('captions/index', [CaptionController::class, 'index']);
    Route::get('captions/object', [CaptionController::class, 'getAllObjects']);
    Route::delete('captions/delete', [CaptionController::class, 'destroy']);
    Route::get('captions/keys', [CaptionController::class, 'getKyes']);
    Route::get('captions/get-code/{code}', [CaptionController::class, 'getByCode']);
    Route::apiResource('captions', CaptionController::class);

    // Messages
    Route::get('messages/object', [MessageController::class, 'index']);
    Route::get('messages', [MessageController::class, 'getAllObjects']);
    Route::post('messages', [MessageController::class, 'store']);
    Route::patch('messages/{message}', [MessageController::class, 'update']);

    //    ==========================================*TEMPS*==========================================
    Route::get('accounts', [TempController::class, 'tempAccounts']);
    Route::get('employees', [TempController::class, 'tempEmployees']);
    Route::get('groups', [TempController::class, 'tempGroups']);
    Route::get('cost-centers', [TempController::class, 'tempCostCenters']);
    Route::get('projects', [TempController::class, 'tempProjects']);
    Route::get('users', [TempController::class, 'tempUsers']);

    //setting
    Route::patch('settings/update', [SettingController::class, 'update']);
    Route::post('settings/index', [SettingController::class, 'index']);

    //Business
    Route::get('business/latest-id', [BusinessController::class, 'latestId']);
    Route::get('business/names', [BusinessController::class, 'getNames']);
    Route::post('business/index', [BusinessController::class, 'index']);
    Route::delete('business/delete', [BusinessController::class, 'destroy']);
    Route::post('business/code', [BusinessController::class, 'getCode']);
    Route::post('business/navigation/{business}', [BusinessController::class, 'navigate']);
    Route::apiResource('business', BusinessController::class);

    // Bills
    Route::post('bills/index', [BillController::class, 'index']);
    Route::get('bills/latest-id', [BillController::class, 'latestId']);
    Route::delete('bills/delete', [BillController::class, 'destroy']);
    Route::post('bills/code', [BillController::class, 'getCode']);
    Route::get('bills/names', [BillController::class, 'getNames']);
    Route::post('bills/navigation/{bill}', [BillController::class, 'navigate']);
    Route::post('item-balance', [BillController::class, 'itemBalance']);
    Route::apiResource('bills', BillController::class);


    Route::post('bills/newproduct', [BillController::class, 'newproduct']);
    Route::post('bills/average', [BillController::class, 'average']);


    //Bill Instalment
    Route::post('bill-installment', [BillInstallmentController::class, 'requestHandling']);
    Route::get('bill-installment/{billId}', [BillInstallmentController::class, 'show']);
});
