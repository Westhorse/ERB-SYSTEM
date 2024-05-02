<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

use Modules\Common\Repositories\IRepositories\{
    Area\IBranchRepository,
    Area\ICountryRepository,
    Area\IRegionRepository,
    BillTypeGroup\IBillTypeGroupRepository,
    ICarStatusRepository,
    ICarClassificationRepository,
    IDocumentIssuerRepository,
    IDocumentTypeRepository,
    IExampleRepository,
    Nationality\INationalityRepository,
    TimeZone\ITimeZoneRepository,
    Unit\IUnitRepository,
    IPaymentTypeRepository,
    Localization\IDistrictRepository,
    Vehicle\IVehicleTypeRepository,
    Vehicle\IWheelRepository,
    Vehicle\IVehicleDataRepository,
    Currency\ICurrencyRepository,
    Setting\ISettingRepository
};
use Modules\Common\Repositories\Eloquent\{
    Area\BranchRepository,
    Area\CountryRepository,
    Area\RegionRepository,
    BillTypeGroup\BillTypeGroupGroupRepository,
    CarStatusRepository,
    DocumentIssuerRepository,
    CarClassificationRepository,
    DocumentTypeRepository,
    ExampleRepository,
    Localization\DistrictRepository,
    Nationality\NationalityRepository,
    TimeZone\TimeZoneRepository,
    Unit\UnitRepository,
    PaymentTypeRepository,
    Vehicle\VehicleTypeRepository,
    Vehicle\WheelRepository,
    Vehicle\VehicleDataRepository,
    Tax\TaxRepository,
    Setting\SettingRepository,
    Business\BusinessRepository,
    LanguageShortcut\LanguageShortcutRepository
};
use Modules\Common\Repositories\Eloquent\Bill\BillRepository;
use Modules\Common\Repositories\Eloquent\BillInstallments\BillInstallmentRepository;
use Modules\Common\Repositories\Eloquent\Languages\LanguageRepository;
use Modules\Common\Repositories\Eloquent\Translations\CaptionRepository;
use Modules\Common\Repositories\Eloquent\Translations\DefaultValueRepository;
use Modules\Common\Repositories\IRepositories\Languages\ILanguageRepository;
use Modules\Common\Repositories\IRepositories\Translations\ICaptionRepository;
use Modules\Common\Repositories\IRepositories\Translations\IDefaultValueRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeDefaultDetailRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeDefaultRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeTaxRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeUserSettingDetailRepository;
use Modules\Common\Repositories\Eloquent\BillType\BillTypeUserSettingRepository;
use Modules\Common\Repositories\Eloquent\Currency\CurrencyRepository;
use Modules\Common\Repositories\Eloquent\Translations\MessageRepository;
use Modules\Common\Repositories\IRepositories\Bill\IBillRepository;
use Modules\Common\Repositories\IRepositories\BillInstallments\IBillInstallmentRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeDefaultDetailRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeDefaultRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeTaxRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeUserSettingDetailRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeUserSettingRepository;
use Modules\Common\Repositories\IRepositories\Business\IBusinessRepository;
use Modules\Common\Repositories\IRepositories\LanguageShortcut\ILanguageShortcutRepository;
use Modules\Common\Repositories\IRepositories\Tax\ITaxRepository;
use Modules\Common\Repositories\IRepositories\Translations\IMessageRepository;
use Modules\FixedAsset\Repositories\Eloquent\AssetStatus\AssetStatusRepository;
use Modules\FixedAsset\Repositories\Eloquent\AssetTransfer\AssetTransferRepository;
use Modules\FixedAsset\Repositories\Eloquent\FixedAssetGroupRepository;
use Modules\FixedAsset\Repositories\IRepositories\IAssetStatus\IAssetStatusRepository;
use Modules\FixedAsset\Repositories\IRepositories\IAssetTransfer\IAssetTransferRepository;
use Modules\FixedAsset\Repositories\IRepositories\IFixedAssetGroupRepository;
use Modules\POS\Repositories\Eloquent\Account\AccountRepository;
use Modules\POS\Repositories\Eloquent\Cashier\CashierRepository;
use Modules\POS\Repositories\Eloquent\CashTransfer\CashTransferRepository;
use Modules\POS\Repositories\Eloquent\Member\MemberRepository;
use Modules\POS\Repositories\Eloquent\Period\PeriodRepository;
use Modules\POS\Repositories\Eloquent\PointSection\PointSectionRepository;
use Modules\POS\Repositories\IRepositories\Account\IAccountRepository;
use Modules\POS\Repositories\IRepositories\Cashier\ICashierRepository;
use Modules\POS\Repositories\IRepositories\CashTransfer\ICashTransferRepository;
use Modules\POS\Repositories\IRepositories\IPeriod\IPeriodRepository;
use Modules\POS\Repositories\IRepositories\IPointSection\IPointSectionRepository;
use Modules\POS\Repositories\IRepositories\Member\IMemberRepository;
use Modules\Warehouse\Repositories\Eloquent\Customer\CustomerRepository;
use Modules\Warehouse\Repositories\Eloquent\DocumentaryCreditType\DocumentaryCreditTypeRepository;
use Modules\Warehouse\Repositories\Eloquent\Documentry\DocumentryCreditExpenseTypeRepository;
use Modules\Warehouse\Repositories\Eloquent\Guarantee\GuaranteeRepository;
use Modules\Warehouse\Repositories\Eloquent\Inventory\InventoryRepository;
use Modules\Warehouse\Repositories\Eloquent\Offer\OfferDetailRepository;
use Modules\Warehouse\Repositories\Eloquent\Offer\OfferRepository;
use Modules\Warehouse\Repositories\Eloquent\Product\PriceListRepository;
use Modules\Warehouse\Repositories\Eloquent\Product\ProductCategoryRepository;
use Modules\Warehouse\Repositories\Eloquent\Product\ProductDeterminantRepository;
use Modules\Warehouse\Repositories\Eloquent\Product\ProductRepository;
use Modules\Warehouse\Repositories\Eloquent\Product\ProductTabulationRepository;
use Modules\Warehouse\Repositories\Eloquent\ShippingPolicy\ShippingPolicyRepository;
use Modules\Warehouse\Repositories\Eloquent\Supplier\SupplierRepository;
use Modules\Warehouse\Repositories\Eloquent\Tag\TagRepository;
use Modules\Warehouse\Repositories\Eloquent\Tax\TaxDetailRepository;
use Modules\Warehouse\Repositories\Eloquent\TransferItemsVoucher\TransferItemsVoucherRepository;
use Modules\Warehouse\Repositories\Eloquent\Unit\UnitRepository as UnitUnitRepository;
use Modules\Warehouse\Repositories\Eloquent\Warehouse\WarehouseRepository;
use Modules\Warehouse\Repositories\IRepositories\Customer\ICustomerRepository;
use Modules\Warehouse\Repositories\IRepositories\DocumentaryCreditType\IDocumentaryCreditTypeRepository;
use Modules\Warehouse\Repositories\IRepositories\Documentry\IDocumentryCreditExpenseTypeRepository;
use Modules\Warehouse\Repositories\IRepositories\Guarantee\IGuaranteeRepository;
use Modules\Warehouse\Repositories\IRepositories\Inventory\IInventoryRepository;
use Modules\Warehouse\Repositories\IRepositories\Offer\IOfferDetailRepository;
use Modules\Warehouse\Repositories\IRepositories\Offer\IOfferRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IPriceListRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductCategoryRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductDeterminantRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductRepository;
use Modules\Warehouse\Repositories\IRepositories\Product\IProductTabulationRepository;
use Modules\Warehouse\Repositories\IRepositories\ShippingPolicy\IShippingPolicyRepository;
use Modules\Warehouse\Repositories\IRepositories\Supplier\ISupplierRepository;
use Modules\Warehouse\Repositories\IRepositories\Tag\ITagRepository;
use Modules\Warehouse\Repositories\IRepositories\Tax\ITaxDetailRepository;
use Modules\Warehouse\Repositories\IRepositories\TransferItemsVoucher\ITransferItemsVoucherRepository;
use Modules\Warehouse\Repositories\IRepositories\Unit\IUnitRepository as UnitIUnitRepository;
use Modules\Warehouse\Repositories\IRepositories\Warehouse\IWarehouseRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Common 
        
        $this->app->bind(ITaxRepository::class, TaxRepository::class);
        $this->app->bind(IExampleRepository::class, ExampleRepository::class);
        //Area
        $this->app->bind(IBranchRepository::class, BranchRepository::class);
        $this->app->bind(IRegionRepository::class, RegionRepository::class);
        $this->app->bind(ICountryRepository::class, CountryRepository::class);
        $this->app->bind(IPaymentTypeRepository::class, PaymentTypeRepository::class);
        $this->app->bind(IDocumentTypeRepository::class, DocumentTypeRepository::class);
        $this->app->bind(IVehicleTypeRepository::class, VehicleTypeRepository::class);
        $this->app->bind(IWheelRepository::class, WheelRepository::class);
        $this->app->bind(ICarStatusRepository::class, CarStatusRepository::class);
        $this->app->bind(ICarClassificationRepository::class, CarClassificationRepository::class);
        $this->app->bind(IDocumentIssuerRepository::class, DocumentIssuerRepository::class);
        $this->app->bind(IVehicleDataRepository::class, VehicleDataRepository::class);
        $this->app->bind(IDistrictRepository::class, DistrictRepository::class);
        $this->app->bind(ICurrencyRepository::class, CurrencyRepository::class);
        $this->app->bind(IUnitRepository::class, UnitRepository::class);
        $this->app->bind(INationalityRepository::class, NationalityRepository::class);
        $this->app->bind(ISettingRepository::class, SettingRepository::class);
        $this->app->bind(IBillTypeGroupRepository::class, BillTypeGroupGroupRepository::class);
        $this->app->bind(ILanguageRepository::class, LanguageRepository::class);
        $this->app->bind(IDefaultValueRepository::class, DefaultValueRepository::class);
        $this->app->bind(ICaptionRepository::class, CaptionRepository::class);
        $this->app->bind(IMessageRepository::class, MessageRepository::class);
        $this->app->bind(IBillTypeRepository::class, BillTypeRepository::class);
        $this->app->bind(IBillTypeDefaultRepository::class, BillTypeDefaultRepository::class);
        $this->app->bind(IBillTypeDefaultDetailRepository::class, BillTypeDefaultDetailRepository::class);
        $this->app->bind(IBillTypeUserSettingRepository::class, BillTypeUserSettingRepository::class);
        $this->app->bind(IBillTypeUserSettingDetailRepository::class, BillTypeUserSettingDetailRepository::class);
        $this->app->bind(IBillTypeTaxRepository::class, BillTypeTaxRepository::class);
        $this->app->bind(IBusinessRepository::class, BusinessRepository::class);
        $this->app->bind(ITimeZoneRepository::class, TimeZoneRepository::class);
        $this->app->bind(IBillRepository::class, BillRepository::class);
        $this->app->bind(IBillInstallmentRepository::class, BillInstallmentRepository::class);
        $this->app->bind(ILanguageShortcutRepository::class, LanguageShortcutRepository::class);


        // FixedAssets 

        $this->app->bind(IFixedAssetGroupRepository::class, FixedAssetGroupRepository::class);
        $this->app->bind(IAssetStatusRepository::class, AssetStatusRepository::class);
        $this->app->bind(IAssetTransferRepository::class, AssetTransferRepository::class);


        // POS

        $this->app->bind(IAccountRepository::class, AccountRepository::class);
        $this->app->bind(ICashierRepository::class, CashierRepository::class);
        $this->app->bind(IPeriodRepository::class, PeriodRepository::class);
        $this->app->bind(IAccountRepository::class, AccountRepository::class);
        $this->app->bind(IMemberRepository::class, MemberRepository::class);
        $this->app->bind(IPointSectionRepository::class, PointSectionRepository::class);
        $this->app->bind(ICashTransferRepository::class, CashTransferRepository::class);

        // Warehouse

        $this->app->bind(IProductDeterminantRepository::class, ProductDeterminantRepository::class);
        $this->app->bind(IPriceListRepository::class, PriceListRepository::class);
        $this->app->bind(IProductTabulationRepository::class, ProductTabulationRepository::class);
        $this->app->bind(IProductRepository::class, ProductRepository::class);
        $this->app->bind(IWarehouseRepository::class, WarehouseRepository::class);
        $this->app->bind(ITagRepository::class, TagRepository::class);
        $this->app->bind(ICustomerRepository::class, CustomerRepository::class);
        $this->app->bind(IGuaranteeRepository::class, GuaranteeRepository::class);
        $this->app->bind(ITaxDetailRepository::class, TaxDetailRepository::class);
        $this->app->bind(IProductCategoryRepository::class, ProductCategoryRepository::class);
        $this->app->bind(IProductCategoryTaxRepository::class, ProductCategoryTaxRepository::class);
        $this->app->bind(UnitIUnitRepository::class, UnitUnitRepository::class);
        $this->app->bind(ISupplierRepository::class, SupplierRepository::class);
        $this->app->bind(IOfferRepository::class, OfferRepository::class);
        $this->app->bind(IOfferDetailRepository::class, OfferDetailRepository::class);
        $this->app->bind(IShippingPolicyRepository::class, ShippingPolicyRepository::class);
        $this->app->bind(IDocumentryCreditExpenseTypeRepository::class, DocumentryCreditExpenseTypeRepository::class);
        $this->app->bind(IDocumentaryCreditTypeRepository::class, DocumentaryCreditTypeRepository::class);
        $this->app->bind(ITransferItemsVoucherRepository::class, TransferItemsVoucherRepository::class);
        $this->app->bind(IInventoryRepository::class, InventoryRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
