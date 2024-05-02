<?php

use Illuminate\Support\Facades\Route;
use Modules\Warehouse\Http\Controllers\Api\Customer\CustomerController;
use Modules\Warehouse\Http\Controllers\Api\DocumentaryCreditType\DocumentaryCreditTypeController;
use Modules\Warehouse\Http\Controllers\Api\Documentry\DocumentryCreditExpenseTypeController;
use Modules\Warehouse\Http\Controllers\Api\Guarantee\GuaranteeController;
use Modules\Warehouse\Http\Controllers\Api\Inventory\InventoryController;
use Modules\Warehouse\Http\Controllers\Api\Offer\OfferController;
use Modules\Warehouse\Http\Controllers\Api\Product\DeterminantController;
use Modules\Warehouse\Http\Controllers\Api\Product\PriceListController;
use Modules\Warehouse\Http\Controllers\Api\Product\ProductCategoryController;
use Modules\Warehouse\Http\Controllers\Api\Product\ProductController;
use Modules\Warehouse\Http\Controllers\Api\Product\ProductTabulationController;
use Modules\Warehouse\Http\Controllers\Api\ShippingPolicy\ShippingPolicyController;
use Modules\Warehouse\Http\Controllers\Api\Supplier\SupplierController;
use Modules\Warehouse\Http\Controllers\Api\Tag\TagController;
use Modules\Warehouse\Http\Controllers\Api\TransferItemsVoucher\TransferItemsVoucherController;
use Modules\Warehouse\Http\Controllers\Api\Unit\UnitController;
use Modules\Warehouse\Http\Controllers\Api\Warehouse\WarehouseController;

Route::group(['middleware' => ['Language']], function () {
    Route::get('languages/{lang}', [\App\Http\Controllers\LanguageController::class, 'update']);


    // navigate

    Route::post("warehouses/navigation/{warehouse}", [WarehouseController::class, 'navigate']);


    //product  done

    Route::post('products/taxes-by-country', [ProductController::class, 'getProductTaxes']);
    Route::post('products/{product}/convert', [ProductController::class, 'getConvert']);
    Route::get('products/{product}/units', [ProductController::class, 'productUnits']);
    Route::get('products/names', [ProductController::class, 'getNames']);
    Route::post('products/index', [ProductController::class, 'index']);
    Route::get('products/latest-id', [ProductController::class, 'latestId']);
    Route::delete('products/delete', [ProductController::class, 'destroy']);
    Route::post('products/code', [ProductController::class, 'getCode']);
    Route::post('products/navigation/{product}', [ProductController::class, 'navigate']);
    Route::apiResource('products', ProductController::class);
    Route::delete('products/deletetree/{product}', [ProductController::class, 'deletetree']);
    Route::post('field/{name}', [ProductController::class, 'getfield']);
    Route::post('checkProductWarehouse', [ProductController::class, 'checkfield']);
    Route::post('insertProductWarehouse', [ProductController::class, 'insertfield']);
    Route::get('test', [ProductController::class, 'test']);
    Route::post('products/{product}/product', [ProductController::class, 'testProduct']);
    Route::post('priceList/test/{as}', [ProductController::class, 'getTest']);




    //Product Determinant   done
    Route::post('determinants/index', [DeterminantController::class, 'index']);
    Route::get('determinants/names', [DeterminantController::class, 'getNames']);
    Route::get('determinants/latest-id', [DeterminantController::class, 'latestId']);
    Route::delete('determinants/delete', [DeterminantController::class, 'destroy']);
    Route::post('determinants/code', [DeterminantController::class, 'getCode']);
    Route::post('determinants/navigation/{determinant}', [DeterminantController::class, 'navigate']);
    Route::apiResource('determinants', DeterminantController::class);



    //ProductTabulation  done
    Route::post('product-tabulations/index', [ProductTabulationController::class, 'index']);
    Route::get('product-tabulations/latest-id', [ProductTabulationController::class, 'latestId']);
    Route::delete('product-tabulations/delete', [ProductTabulationController::class, 'destroy']);
    Route::post('product-tabulations/code', [ProductTabulationController::class, 'getCode']);
    Route::post('product-tabulations/navigation/{productTabulation}', [ProductTabulationController::class, 'navigate']);
    Route::apiResource('product-tabulations', ProductTabulationController::class);



    //PriceList done
    Route::post('price-lists/index', [PriceListController::class, 'index']);
    Route::get('price-lists/latest-id', [PriceListController::class, 'latestId']);
    Route::delete('price-lists/delete', [PriceListController::class, 'destroy']);
    Route::post('price-lists/code', [PriceListController::class, 'getCode']);
    Route::post('price-lists/navigation/{priceList}', [PriceListController::class, 'navigate']);
    Route::apiResource('price-lists', PriceListController::class);




    // Product Category
    Route::get('product-categories/latest-id', [ProductCategoryController::class, 'latestId']);
    Route::get('product-categories/names', [ProductCategoryController::class, 'getNames']);

    Route::get('product-categories/showProduct/{productCategory}', [ProductCategoryController::class, 'showProduct']);

    Route::patch('product-categories/updateProductCategories/{productCategory}', [ProductCategoryController::class, 'updateProduct']);

    Route::get('product-categories/names-with-fixed-asset-type', [ProductCategoryController::class, 'getNamesWithTypeIsFixedAsset']);
    Route::post('product-categories/names-with-type', [ProductCategoryController::class, 'getNamesWithType']);
    Route::delete('product-categories/delete', [ProductCategoryController::class, 'destroy']);
    Route::post('product-categories/index', [ProductCategoryController::class, 'index']);
    Route::get('product-categories/units', [ProductCategoryController::class, 'getUnits']);
    Route::get('product-categories/constants', [ProductCategoryController::class, 'getConstants']);
    Route::post('product-categories/code', [ProductCategoryController::class, 'getCode']);
    Route::post('product-categories/child-code', [ProductCategoryController::class, 'getCodeWhenHasParent']);
    Route::post('product-categories/navigation/{productCategory}', [ProductCategoryController::class, 'navigate']);
    Route::apiResource('product-categories', ProductCategoryController::class)->parameter('product_category', 'productCategory');

    Route::post("product-categories/tree/get-parents", [ProductCategoryController::class, 'getParents']);

    // Route::get('product-categories/tree/{productCategory}', [ProductCategoryController::class, 'gettree']);


    // warehouses routes
    Route::post('warehouses/index', [WarehouseController::class, 'index']);
    Route::get('warehouses/latest-id', [WarehouseController::class, 'latestId']);
    Route::get('warehouses/names', [WarehouseController::class, 'getNames']);
    Route::delete('warehouses/delete', [WarehouseController::class, 'destroy']);
    Route::post('warehouses/code', [WarehouseController::class, 'getCode']);
    Route::get("warehouses/get-parents", [WarehouseController::class, 'getParents']);
    Route::apiResource("warehouses", WarehouseController::class);
    Route::post('warehouses/child-code', [WarehouseController::class, 'getCodeWhenHasParent']);


    //supplier
    Route::post('suppliers/index', [SupplierController::class, 'index']);
    Route::get('suppliers/latest-id', [SupplierController::class, 'latestId']);
    Route::delete('suppliers/delete', [SupplierController::class, 'destroy']);
    Route::post('suppliers/navigation/{supplier}', [SupplierController::class, 'navigate']);
    Route::post('suppliers/code', [SupplierController::class, 'getCode']);
    Route::apiResource("suppliers", SupplierController::class);

    //customers
    Route::post('customers/index', [CustomerController::class, 'index']);
    Route::get('customers/latest-id', [CustomerController::class, 'latestId']);
    Route::delete('customers/delete', [CustomerController::class, 'destroy']);
    Route::post('customers/navigation/{customer}', [CustomerController::class, 'navigate']);
    Route::post('customers/code', [CustomerController::class, 'getCode']);
    Route::apiResource("customers", CustomerController::class);

    //DocumentryCreditExpenseType
    Route::post('documentry-credit-expense-type/index', [DocumentryCreditExpenseTypeController::class, 'index']);
    Route::get('documentry-credit-expense-type/latest-id', [DocumentryCreditExpenseTypeController::class, 'latestId']);
    Route::delete('documentry-credit-expense-type/delete', [DocumentryCreditExpenseTypeController::class, 'destroy']);
    Route::post('documentry-credit-expense-type/navigation/{documentry}', [DocumentryCreditExpenseTypeController::class, 'navigate']);
    Route::post('documentry-credit-expense-type/code', [DocumentryCreditExpenseTypeController::class, 'getCode']);
    Route::apiResource("documentry-credit-expense-type", DocumentryCreditExpenseTypeController::class);

    // Tag
    Route::get('tags/latest-id', [TagController::class, 'latestId']);
    Route::post('tags/index', [TagController::class, 'index']);
    Route::get('tags/tag-name/{tag}', [TagController::class, 'tagName']);
    Route::post('tags/code', [TagController::class, 'getCode']);
    Route::post('tags/navigation/{tag}', [TagController::class, 'navigate']);
    Route::apiResource('tags', TagController::class);

    // Guarantee
    Route::get('guarantees/latest-id', [GuaranteeController::class, 'latestId']);
    Route::delete('guarantees/delete', [GuaranteeController::class, 'destroy']);
    Route::post('guarantees/index', [GuaranteeController::class, 'index']);
    Route::get('guarantees/guarantee-name/{guarantee}', [GuaranteeController::class, 'guaranteeName']);
    Route::post('guarantees/code', [GuaranteeController::class, 'getCode']);
    Route::post('guarantees/navigation/{guarantee}', [GuaranteeController::class, 'navigate']);
    Route::apiResource('guarantees', GuaranteeController::class);

    // Tax
    // Route::post('taxes/index', [TaxController::class, 'index']);
    // Route::get('taxes/latest-id', [TaxController::class, 'latestId']);
    // Route::post('taxes/code', [TaxController::class, 'getCode']);
    // Route::post('taxes/navigation/{tax}', [TaxController::class, 'navigate']);
    // Route::apiResource('taxes', TaxController::class);



    // Unit
    Route::get('units/latest-id', [UnitController::class, 'latestId']);
    Route::get('units/names', [UnitController::class, 'getNames']);
    Route::post('units/index', [UnitController::class, 'index']);
    Route::post('units/code', [UnitController::class, 'getCode']);
    Route::get('units/unit-name/{unit}', [UnitController::class, 'unitName']);
    // Route::post('units/names', [UnitController::class, 'unitsNames']);
    Route::post('units/navigation/{unit}', [UnitController::class, 'navigate']);
    Route::apiResource('units', UnitController::class);

    // Offer done
    Route::post('offers/index', [OfferController::class, 'index']);
    Route::get('offers/latest-id', [OfferController::class, 'latestId']);
    Route::post('offers/delete', [OfferController::class, 'destroy']);
    Route::post('offers/code', [OfferController::class, 'getCode']);
    Route::post('offers/navigation/{offer}', [OfferController::class, 'navigate']);
    Route::apiResource('offers', OfferController::class);

    // // Offer-details
    // Route::post('offer-details/index', [OfferDetailController::class, 'index']);
    // Route::post('offer-details/navigation/{offer}', [OfferDetailController::class, 'navigate']);
    // Route::apiResource('offer-details', OfferDetailController::class)->parameter('offer_details', 'offerDetail');


    // Shipping Policy
    Route::get('shipping-policy/latest-id', [ShippingPolicyController::class, 'latestId']);
    Route::get('shipping-policy/names', [ShippingPolicyController::class, 'getNames']);
    Route::delete('shipping-policy/delete', [ShippingPolicyController::class, 'destroy']);
    Route::post('shipping-policy/index', [ShippingPolicyController::class, 'index']);
    Route::post('shipping-policy/code', [ShippingPolicyController::class, 'getCode']);
    Route::post('shipping-policy/navigation/{shipping_policy}', [ShippingPolicyController::class, 'navigate']);
    Route::apiResource('shipping-policy', ShippingPolicyController::class);

    // Documentary Credit Type
    Route::get('documentary-credit-type/latest-id', [DocumentaryCreditTypeController::class, 'latestId']);
    Route::delete('documentary-credit-type/delete', [DocumentaryCreditTypeController::class, 'destroy']);
    Route::post('documentary-credit-type/index', [DocumentaryCreditTypeController::class, 'index']);
    Route::post('documentary-credit-type/code', [DocumentaryCreditTypeController::class, 'getCode']);
    Route::post('documentary-credit-type/navigation/{documentary_credit_type}', [DocumentaryCreditTypeController::class, 'navigate']);
    Route::apiResource('documentary-credit-type', DocumentaryCreditTypeController::class);

    //Transfer Items Vouchers
    Route::post('transfer-items-vouchers/index', [TransferItemsVoucherController::class, 'index']);
    Route::get('transfer-items-vouchers/latest-id', [TransferItemsVoucherController::class, 'latestId']);
    Route::delete('transfer-items-vouchers/delete', [TransferItemsVoucherController::class, 'destroy']);
    Route::post('transfer-items-vouchers/navigation/{transferItemsVoucher}', [TransferItemsVoucherController::class, 'navigate']);
    Route::apiResource('transfer-items-vouchers', TransferItemsVoucherController::class);


    // inventory
    Route::get('inventories/latest-id', [InventoryController::class, 'latestId']);
    Route::post('inventories/list-items', [InventoryController::class, 'gatherItems']);
    Route::post('inventories/approval/{inventory}', [InventoryController::class, 'approve']);
    Route::get('inventories/filltered-names', [InventoryController::class, 'getFillteredNames']);
    Route::get('inventories/names', [InventoryController::class, 'getNames']);
    Route::post('inventories/index', [InventoryController::class, 'index']);
    Route::post('inventories/code', [InventoryController::class, 'getCode']);
    Route::post('inventories/navigation/{inventory}', [InventoryController::class, 'navigate']);
    Route::apiResource('inventories', InventoryController::class);
});
