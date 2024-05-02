<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillType;
use App\Repositories\Eloquent\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Translations\Caption;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeRepository;

class BillTypeRepository extends BaseRepository implements IBillTypeRepository
{
    public function model()
    {
        return BillType::class;
    }
    public function nameCaption($billType, $request)
    {
        Caption::updateOrCreate(
            [
                'key' =>  'bill-type-' . $billType['id']
            ],
            [
                "code" => '5',
                "key" => 'bill-type-' . $billType['id'],
                "value" =>  $request['name'],
                "is_active" => 1,
            ]
        );
    }
    public function createRequest($request)
    {
        try {
            DB::beginTransaction();

            $modelObject = $this->model->create([
                'name' => $request['name'],
                'branch_id' => $request['branch_id'],
                'group_id' => $request['group_id'],
                'type_id' => $request['type_id'],
                'stocking_effect' => $request['stocking_effect'],
                'cost_price_effect' => $request['cost_price_effect'],
                'discount_cost_price_effect' => $request['discount_cost_price_effect'],
                'add_cost_price_effect' => $request['add_cost_price_effect'],
                'distribution_type' => $request['distribution_type'],
                'accounting_effect' => $request['accounting_effect'],
                'automatic_accounting_posting' => $request['automatic_accounting_posting'],
                'bill_section' => $request['bill_section'],
                'compound_Journal' => $request['compound_Journal'],
                'sum_debit_acc' => $request['sum_debit_acc'],
                'sum_credit_acc' => $request['sum_credit_acc'],
                'load_generated_journal' => $request['load_generated_journal'],
                'exchange_expenses_income_acc' => $request['exchange_expenses_income_acc'],
                'exchange_product_stock_acc' => $request['exchange_product_stock_acc'],
                'post_bill_cost' => $request['post_bill_cost'],
                'account_balance' => $request['account_balance'],
                'automatic_save_bill' => $request['automatic_save_bill'],
                'random_serials' => $request['random_serials'],
                'ignore_product_add_discount' => $request['ignore_product_add_discount'],
                'cost_center_mandatory' => $request['cost_center_mandatory'],
                'representative_mandatory' => $request['representative_mandatory'],
                'multi_version' => $request['multi_version'],
                'code_per_user' => $request['code_per_user'],
                'time_limit' => $request['time_limit'],
                'cost_center_type' => $request['cost_center_type'],
                'payment_voucher_id' => $request['payment_voucher_id'],
                'currency_id' => $request['currency_id'],
                'accumulated_bill_type_id' => $request['accumulated_bill_type_id'],
                'change_bill_type_id' => $request['change_bill_type_id'],
                'qty_approximation_digits' => $request['qty_approximation_digits'],
                'amount_approximation_digits' => $request['amount_approximation_digits'],
                'barcode_search' => $request['barcode_search'],
                'output_oldest_expire_date' => $request['output_oldest_expire_date'],
                'output_expire_date_purchase_date' => $request['output_expire_date_purchase_date'],
                'expire_date_purchase_discount' => $request['expire_date_purchase_discount'],
                'edit_item_qty' => $request['edit_item_qty'],
                'update_query' => $request['update_query'],
                'product_category_filter' => $request['product_category_filter'],
                'contact_filter_by_company' => $request['contact_filter_by_company'],
                'use_smpile_bill' => $request['use_smpile_bill'],
                'calculate_compound_price' => $request['calculate_compound_price'],
                'consider_payment_value_in_Bill_paid' => $request['consider_payment_value_in_Bill_paid'],
                'offer_id' => $request['offer_id'],
                'use_price_from_last_offer' => $request['use_price_from_last_offer'],
                'use_price_list' => $request['use_price_list'],
                'discount_qty_as_percent' => $request['discount_qty_as_percent'],
                'add_qty_as_percent' => $request['add_qty_as_percent'],
                'payment_terms_with_net_invoice' => $request['payment_terms_with_net_invoice'],
                'open_drawer_with_add' => $request['open_drawer_with_add'],
                'pirce_modification_with_total_modification' => $request['pirce_modification_with_total_modification'],
                'connect_with_customs_transaction' => $request['connect_with_customs_transaction'],
                'max_item_qty' => $request['max_item_qty'],
                'company_filter_acc' => $request['company_filter_acc'],
                'use_touch_screen' => $request['use_touch_screen'],
                'connect_with_employee_vehicle' => $request['connect_with_employee_vehicle'],
                'modify_vehicle_weight' => $request['modify_vehicle_weight'],
                'use_default_warehouse' => $request['use_default_warehouse'],
                'generate_voucher_to_warehouse' => $request['generate_voucher_to_warehouse'],
                'normal_price_color' => $request['normal_price_color'],
                'min_cost_price_color' => $request['min_cost_price_color'],
                'min_sell_price_color' => $request['min_sell_price_color'],
                'negative_qty_color' => $request['negative_qty_color'],
                'exceed_min_limit_color' => $request['exceed_min_limit_color'],
                'exceed_max_limit_color' => $request['exceed_max_limit_color'],
                'exceed_zero_qty_color' => $request['exceed_zero_qty_color'],
                'price_from_offers_color' => $request['price_from_offers_color'],
                'tax_exemption' => $request['tax_exemption'],
                'manual_tax_entry' => $request['manual_tax_entry'],
                'tax_base' => $request['tax_base'],
                'generate_transfer_bill' => $request['generate_transfer_bill'],
                'show_transfer_bill' => $request['show_transfer_bill'],
                'transfer_warehouse_id' => $request['transfer_warehouse_id'],
                'in_bill_type_id' => $request['in_bill_type_id'],
                'out_bill_type_id' => $request['out_bill_type_id'],
                'transfer_branch_id' => $request['transfer_branch_id'],
                'transfer_price' => $request['transfer_price'],
                'hide_closed_ref' => $request['hide_closed_ref'],
                'hide_services_items' => $request['hide_services_items'],
                'confirm_ref' => $request['confirm_ref'],
                'default_ref' => $request['default_ref'],
                'choose_customer_before_ref' => $request['choose_customer_before_ref'],
                'delete_bill_ref' => $request['delete_bill_ref'],
                'update_prices_from_bill_prices' => $request['update_prices_from_bill_prices'],
                'add_to_exist_items' => $request['add_to_exist_items'],
                'automatic_load_items' => $request['automatic_load_items'],
                'apply_ref_discount' => $request['apply_ref_discount'],
                'apply_ref_qty_discount' => $request['apply_ref_qty_discount'],
                'show_ref_of_ref' => $request['show_ref_of_ref'],
                'show_ref_number' => $request['show_ref_number'],
                'choose_multi_ref' => $request['choose_multi_ref'],
                'save_ref_number' => $request['save_ref_number'],
                'add_ref_info' => $request['add_ref_info'],
                'update_expire_date' => $request['update_expire_date'],
                'get_bill_ref' => $request['get_bill_ref'],
                'get_remakrs' => $request['get_remakrs'],
                'get_payment_conditions' => $request['get_payment_conditions'],
                'get_table_warehouse' => $request['get_table_warehouse'],
                'get_add_discount' => $request['get_add_discount'],
                'get_ref_voucher' => $request['get_ref_voucher'],
                'get_voucher_values_without_tax' => $request['get_voucher_values_without_tax'],
                'get_cost_centers' => $request['get_cost_centers'],
                'get_main_warehouse' => $request['get_main_warehouse'],
                'get_payment_way' => $request['get_payment_way'],
                'get_ref_branch' => $request['get_ref_branch'],
                'get_table_remarks' => $request['get_table_remarks'],
                'get_account' => $request['get_account'],
                'get_bill_ref_number' => $request['get_bill_ref_number'],
                'get_time_limit' => $request['get_time_limit'],
                'search_in_ref_items' => $request['search_in_ref_items'],
                'search_in_opened_ref_items' => $request['search_in_opened_ref_items'],
                'get_additional_data' => $request['get_additional_data'],
                'get_additional_fields' => $request['get_additional_fields'],
                'recalculate_tax' => $request['recalculate_tax'],
                'determinants_replacement' => $request['determinants_replacement'],
                'stock_account_id' => $request['stock_account_id'],
                'donate_account_id' => $request['donate_account_id'],
                'discount_account_id' => $request['discount_account_id'],
                'add_account_id' => $request['add_account_id'],
                'paid_account_id' => $request['paid_account_id'],
                'rest_amount_account_id' => $request['rest_amount_account_id'],
                'allow_selling_non_entry_serial' => $request['allow_selling_non_entry_serial'],
                'cost_account_id' => $request['cost_account_id'],

            ]);
            if (!empty($request['billTypeDefault'])) {
                $billTypeDefaults = $modelObject->billTypeDefaults()->create([
                    'cost_center_id' => $request['billTypeDefault']['cost_center_id'],
                    'employee_id' => $request['billTypeDefault']['employee_id'],
                    'project_id' => $request['billTypeDefault']['project_id'],
                    'discount_account_id' => $request['billTypeDefault']['discount_account_id'],
                    'opposite_discount_account_id' => $request['billTypeDefault']['opposite_discount_account_id'],
                    'warehouse_id' => $request['billTypeDefault']['warehouse_id'],
                    'pos_id' => $request['billTypeDefault']['pos_id'],
                    'payment_type' => $request['billTypeDefault']['payment_type'],
                    'default_price' => $request['billTypeDefault']['default_price'],
                ]);
                if (!empty($request['billTypeDefault']['billTypeDefaultDetail'])) {
                    $billTypeDefaults->billTypeDefaultDetails()->createMany($request['billTypeDefault']['billTypeDefaultDetail'], $billTypeDefaults->id);
                };
            }

            if (!empty($request['billTypeUser'])) {
                foreach ($request['billTypeUser'] as $billTypeUser) {
                    $user = $modelObject->billTypeUserSettings()->create([
                        "user_id" => $billTypeUser['user_id'],
                        "warehouse_id" => $billTypeUser['warehouse_id'],
                        "employee_id" => $billTypeUser['employee_id'],
                        "cost_center_id" => $billTypeUser['cost_center_id'],
                        "project_id" => $billTypeUser['project_id'],
                        "discount_account_id" => $billTypeUser['discount_account_id'],
                        "opposite_discount_account_id" => $billTypeUser['opposite_discount_account_id'],
                        "pos_id" => $billTypeUser['pos_id'],
                        "reference_id" => $billTypeUser['reference_id'],
                        "payment_type" => $billTypeUser['payment_type'],
                        "default_price" => $billTypeUser['default_price'],
                    ]);
                    if (!empty($billTypeUser['billTypeUserDetail'])) {
                        foreach ($billTypeUser['billTypeUserDetail'] as  $billTypeUserDetail) {
                            $user->billTypeUserSettingsDetails()->create($billTypeUserDetail);
                        }
                    };
                }
            }
            if (!empty($request['taxes'])) $modelObject->taxes()->sync($request['taxes']);

            DB::commit();
            return $modelObject;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function updateRequest($billType, $request)
    {
        try {
            DB::beginTransaction();

            $billType->update([
                'name' => $request['name'],
                'branch_id' => $request['branch_id'],
                'group_id' => $request['group_id'],
                'type_id' => $request['type_id'],
                'stocking_effect' => $request['stocking_effect'],
                'cost_price_effect' => $request['cost_price_effect'],
                'discount_cost_price_effect' => $request['discount_cost_price_effect'],
                'add_cost_price_effect' => $request['add_cost_price_effect'],
                'distribution_type' => $request['distribution_type'],
                'accounting_effect' => $request['accounting_effect'],
                'automatic_accounting_posting' => $request['automatic_accounting_posting'],
                'bill_section' => $request['bill_section'],
                'compound_Journal' => $request['compound_Journal'],
                'sum_debit_acc' => $request['sum_debit_acc'],
                'sum_credit_acc' => $request['sum_credit_acc'],
                'load_generated_journal' => $request['load_generated_journal'],
                'exchange_expenses_income_acc' => $request['exchange_expenses_income_acc'],
                'exchange_product_stock_acc' => $request['exchange_product_stock_acc'],
                'post_bill_cost' => $request['post_bill_cost'],
                'account_balance' => $request['account_balance'],
                'automatic_save_bill' => $request['automatic_save_bill'],
                'random_serials' => $request['random_serials'],
                'ignore_product_add_discount' => $request['ignore_product_add_discount'],
                'cost_center_mandatory' => $request['cost_center_mandatory'],
                'representative_mandatory' => $request['representative_mandatory'],
                'multi_version' => $request['multi_version'],
                'code_per_user' => $request['code_per_user'],
                'time_limit' => $request['time_limit'],
                'cost_center_type' => $request['cost_center_type'],
                'payment_voucher_id' => $request['payment_voucher_id'],
                'currency_id' => $request['currency_id'],
                'accumulated_bill_type_id' => $request['accumulated_bill_type_id'],
                'change_bill_type_id' => $request['change_bill_type_id'],
                'qty_approximation_digits' => $request['qty_approximation_digits'],
                'amount_approximation_digits' => $request['amount_approximation_digits'],
                'barcode_search' => $request['barcode_search'],
                'output_oldest_expire_date' => $request['output_oldest_expire_date'],
                'output_expire_date_purchase_date' => $request['output_expire_date_purchase_date'],
                'expire_date_purchase_discount' => $request['expire_date_purchase_discount'],
                'edit_item_qty' => $request['edit_item_qty'],
                'update_query' => $request['update_query'],
                'product_category_filter' => $request['product_category_filter'],
                'contact_filter_by_company' => $request['contact_filter_by_company'],
                'use_smpile_bill' => $request['use_smpile_bill'],
                'calculate_compound_price' => $request['calculate_compound_price'],
                'consider_payment_value_in_Bill_paid' => $request['consider_payment_value_in_Bill_paid'],
                'offer_id' => $request['offer_id'],
                'use_price_from_last_offer' => $request['use_price_from_last_offer'],
                'use_price_list' => $request['use_price_list'],
                'discount_qty_as_percent' => $request['discount_qty_as_percent'],
                'add_qty_as_percent' => $request['add_qty_as_percent'],
                'payment_terms_with_net_invoice' => $request['payment_terms_with_net_invoice'],
                'open_drawer_with_add' => $request['open_drawer_with_add'],
                'pirce_modification_with_total_modification' => $request['pirce_modification_with_total_modification'],
                'connect_with_customs_transaction' => $request['connect_with_customs_transaction'],
                'max_item_qty' => $request['max_item_qty'],
                'company_filter_acc' => $request['company_filter_acc'],
                'use_touch_screen' => $request['use_touch_screen'],
                'connect_with_employee_vehicle' => $request['connect_with_employee_vehicle'],
                'modify_vehicle_weight' => $request['modify_vehicle_weight'],
                'use_default_warehouse' => $request['use_default_warehouse'],
                'generate_voucher_to_warehouse' => $request['generate_voucher_to_warehouse'],
                'normal_price_color' => $request['normal_price_color'],
                'min_cost_price_color' => $request['min_cost_price_color'],
                'min_sell_price_color' => $request['min_sell_price_color'],
                'negative_qty_color' => $request['negative_qty_color'],
                'exceed_min_limit_color' => $request['exceed_min_limit_color'],
                'exceed_max_limit_color' => $request['exceed_max_limit_color'],
                'exceed_zero_qty_color' => $request['exceed_zero_qty_color'],
                'price_from_offers_color' => $request['price_from_offers_color'],
                'tax_exemption' => $request['tax_exemption'],
                'manual_tax_entry' => $request['manual_tax_entry'],
                'tax_base' => $request['tax_base'],
                'generate_transfer_bill' => $request['generate_transfer_bill'],
                'show_transfer_bill' => $request['show_transfer_bill'],
                'transfer_warehouse_id' => $request['transfer_warehouse_id'],
                'in_bill_type_id' => $request['in_bill_type_id'],
                'out_bill_type_id' => $request['out_bill_type_id'],
                'transfer_branch_id' => $request['transfer_branch_id'],
                'transfer_price' => $request['transfer_price'],
                'hide_closed_ref' => $request['hide_closed_ref'],
                'hide_services_items' => $request['hide_services_items'],
                'confirm_ref' => $request['confirm_ref'],
                'default_ref' => $request['default_ref'],
                'choose_customer_before_ref' => $request['choose_customer_before_ref'],
                'delete_bill_ref' => $request['delete_bill_ref'],
                'update_prices_from_bill_prices' => $request['update_prices_from_bill_prices'],
                'add_to_exist_items' => $request['add_to_exist_items'],
                'automatic_load_items' => $request['automatic_load_items'],
                'apply_ref_discount' => $request['apply_ref_discount'],
                'apply_ref_qty_discount' => $request['apply_ref_qty_discount'],
                'show_ref_of_ref' => $request['show_ref_of_ref'],
                'show_ref_number' => $request['show_ref_number'],
                'choose_multi_ref' => $request['choose_multi_ref'],
                'save_ref_number' => $request['save_ref_number'],
                'add_ref_info' => $request['add_ref_info'],
                'update_expire_date' => $request['update_expire_date'],
                'get_bill_ref' => $request['get_bill_ref'],
                'get_remakrs' => $request['get_remakrs'],
                'get_payment_conditions' => $request['get_payment_conditions'],
                'get_table_warehouse' => $request['get_table_warehouse'],
                'get_add_discount' => $request['get_add_discount'],
                'get_ref_voucher' => $request['get_ref_voucher'],
                'get_voucher_values_without_tax' => $request['get_voucher_values_without_tax'],
                'get_cost_centers' => $request['get_cost_centers'],
                'get_main_warehouse' => $request['get_main_warehouse'],
                'get_payment_way' => $request['get_payment_way'],
                'get_ref_branch' => $request['get_ref_branch'],
                'get_table_remarks' => $request['get_table_remarks'],
                'get_account' => $request['get_account'],
                'get_bill_ref_number' => $request['get_bill_ref_number'],
                'get_time_limit' => $request['get_time_limit'],
                'search_in_ref_items' => $request['search_in_ref_items'],
                'search_in_opened_ref_items' => $request['search_in_opened_ref_items'],
                'get_additional_data' => $request['get_additional_data'],
                'get_additional_fields' => $request['get_additional_fields'],
                'recalculate_tax' => $request['recalculate_tax'],
                'determinants_replacement' => $request['determinants_replacement'],
                'stock_account_id' => $request['stock_account_id'],
                'donate_account_id' => $request['donate_account_id'],
                'discount_account_id' => $request['discount_account_id'],
                'add_account_id' => $request['add_account_id'],
                'paid_account_id' => $request['paid_account_id'],
                'allow_selling_non_entry_serial' => $request['allow_selling_non_entry_serial'],
                'rest_amount_account_id' => $request['rest_amount_account_id']

            ]);


            if (!empty($request['billTypeDefault'])) {
                $billTypeDefault = $billType->billTypeDefaults()->first();
                $billTypeDefault->update([
                    'cost_center_id' => $request['billTypeDefault']['cost_center_id'],
                    'employee_id' => $request['billTypeDefault']['employee_id'],
                    'project_id' => $request['billTypeDefault']['project_id'],
                    'discount_account_id' => $request['billTypeDefault']['discount_account_id'],
                    'opposite_discount_account_id' => $request['billTypeDefault']['opposite_discount_account_id'],
                    'warehouse_id' => $request['billTypeDefault']['warehouse_id'],
                    'pos_id' => $request['billTypeDefault']['pos_id'],
                    'payment_type' => $request['billTypeDefault']['payment_type'],
                    'default_price' => $request['billTypeDefault']['default_price'],
                ]);
                if (!empty($request['billTypeDefault']['billTypeDefaultDetail'])) {
                    foreach ($request['billTypeDefault']['billTypeDefaultDetail'] as $data) {
                        $object =  isset($data['id']) ? $billTypeDefault->billTypeDefaultDetails()->find($data['id']) : null;
                        if (!$object) {
                            $billTypeDefault->billTypeDefaultDetails()->create([
                                'account_id' => $data['account_id'],
                                'opposite_account_id' => $data['opposite_account_id'],
                                'payment_type' => $data['payment_type'],
                                'label' => $data['label'] ?? null,
                            ]);
                        } else {
                            $object->update([
                                'account_id' => $data['account_id'],
                                'opposite_account_id' => $data['opposite_account_id'],
                                'payment_type' => $data['payment_type'],
                                'label' => $data['label'] ?? null,
                            ]);
                        }
                    };
                }
            }

            if (!empty($request['billTypeUser'])) {
                foreach ($request['billTypeUser'] as $data) {
                    $object =  isset($data['id']) ? $billType->billTypeUserSettings()->find($data['id']) : null;
                    if (!$object) {
                        $object = $billType->billTypeUserSettings()->create([
                            "user_id" => $data['user_id'],
                            "warehouse_id" => $data['warehouse_id'],
                            "employee_id" => $data['employee_id'],
                            "cost_center_id" => $data['cost_center_id'],
                            "project_id" => $data['project_id'],
                            "discount_account_id" => $data['discount_account_id'],
                            "opposite_discount_account_id" => $data['opposite_discount_account_id'],
                            "pos_id" => $data['pos_id'],
                            "reference_id" => $data['reference_id'],
                            "payment_type" => $data['payment_type'],
                            "default_price" => $data['default_price'],
                        ]);
                    } else {
                        $object->update([
                            "user_id" => $data['user_id'],
                            "warehouse_id" => $data['warehouse_id'],
                            "employee_id" => $data['employee_id'],
                            "cost_center_id" => $data['cost_center_id'],
                            "project_id" => $data['project_id'],
                            "discount_account_id" => $data['discount_account_id'],
                            "opposite_discount_account_id" => $data['opposite_discount_account_id'],
                            "pos_id" => $data['pos_id'],
                            "reference_id" => $data['reference_id'],
                            "payment_type" => $data['payment_type'],
                            "default_price" => $data['default_price'],
                        ]);
                    }
                    if (!empty($data['billTypeUserDetail'])) {
                        foreach ($data['billTypeUserDetail'] as $detailData) {
                            $detail = $object->billTypeUserSettingsDetails()->find($detailData['id'] ?? 0);
                            if (!$detail) {
                                $detail = $object->billTypeUserSettingsDetails()->create([
                                    "label" => $detailData['label'] ?? null,
                                    "account_id" => $detailData['account_id'],
                                    "opposite_account_id" => $detailData['opposite_account_id'],
                                    "payment_type" => $detailData['payment_type']
                                ]);
                            } else {
                                $detail->update([
                                    "label" => $detailData['label'] ?? null,
                                    "account_id" => $detailData['account_id'],
                                    "opposite_account_id" => $detailData['opposite_account_id'],
                                    "payment_type" => $detailData['payment_type']
                                ]);
                            }
                        }
                    }
                }
            };

            if (!empty($request['taxes'])) $billType->taxes()->sync($request['taxes']);
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function namesByType($type_id)
    {
        $models =  $this->model->where('type_id', $type_id)->select(['id', 'name', 'is_active'])->orderByRaw("FIELD(is_active,1) DESC")->get();

        return $models;
    }

    public function loadSettings($billType, $settings, $details)
    {
        if (isset($settings)) {
            $billType->settingsData = $settings;
            $billType->settingsData->details = $details;
        }
        return $billType;
    }

    public function getBillTypeSetting($billType, $request)
    {
        $setting = $billType->billTypeUserSettings()->where('user_id',  $request['user_id'])->first();
        if (isset($setting)) {
            $settingDetails = $setting->billTypeUserSettingsDetails()->where('payment_type',  $request['payment_type'])->first();
            $allSettingDetails = $setting->billTypeUserSettingsDetails()->where('payment_type', 0)->first();
        }

        $defaults = $billType->billTypeDefaults()->first();
        if (isset($defaults)) {

            $defaultDetails = $defaults->billTypeDefaultDetails()->where('payment_type',  $request['payment_type'])->first();
            $allDefaultsDetails = $defaults->billTypeDefaultDetails()->where('payment_type',  0)->first();
        }
        $defaultValues = [];
        $defaultValues['id']  =
            isset($setting['id']) ? $setting['id'] : (isset($defaults['id']) ? $defaults['id'] : '');
        $defaultValues['user_id'] =
            isset($setting['user_id']) ? $setting['user_id'] : (isset($defaults['user_id']) ? $defaults['user_id'] : '');
        $defaultValues['warehouse_id'] =
            isset($setting['warehouse_id']) ? $setting['warehouse_id'] : (isset($defaults['warehouse_id']) ? $defaults['warehouse_id'] : '');
        $defaultValues['employee_id'] =
            isset($setting['employee_id']) ? $setting['employee_id'] : (isset($defaults['employee_id']) ? $defaults['employee_id'] : '');
        $defaultValues['cost_center_id'] =
            isset($setting['cost_center_id']) ? $setting['cost_center_id'] : (isset($defaults['cost_center_id']) ? $defaults['cost_center_id'] : '');
        $defaultValues['project_id'] =
            isset($setting['project_id']) ? $setting['project_id'] : (isset($defaults['project_id']) ? $defaults['project_id'] : '');
        $defaultValues['discount_account_id'] =
            isset($setting['discount_account_id']) ? $setting['discount_account_id'] : (isset($defaults['discount_account_id']) ? $defaults['discount_account_id'] : '');
        $defaultValues['opposite_discount_account_id'] =
            isset($setting['opposite_discount_account_id']) ? $setting['opposite_discount_account_id'] : (isset($defaults['opposite_discount_account_id']) ? $defaults['opposite_discount_account_id'] : '');
        $defaultValues['reference_id'] =
            isset($setting['reference_id']) ? $setting['reference_id'] : (isset($defaults['reference_id']) ? $defaults['reference_id'] : '');
        $defaultValues['pos_id'] =
            isset($setting['pos_id']) ? $setting['pos_id'] : (isset($defaults['pos_id']) ? $defaults['pos_id'] : '');
        $defaultValues['payment_type'] =
            isset($setting['payment_type']) ? $setting['payment_type'] : (isset($defaults['payment_type']) ? $defaults['payment_type'] : '');
        $defaultValues['default_price'] =
            isset($setting['default_price']) ? $setting['default_price'] : (isset($defaults['default_price']) ? $defaults['default_price'] : '');

        $defaultValues['detail']['id'] =
            isset($settingDetails['id']) ? $settingDetails['id'] : (isset($allSettingDetails['id']) ? $allSettingDetails['id'] : (isset($defaultDetails['id']) ? $defaultDetails['id'] : (isset($allDefaultsDetails['id']) ? $allDefaultsDetails['id'] : '')));
        $defaultValues['detail']['label'] =
            isset($settingDetails['label']) ? $settingDetails['label'] : (isset($allSettingDetails['label']) ? $allSettingDetails['label'] : (isset($defaultDetails['label']) ? $defaultDetails['label'] : (isset($allDefaultsDetails['label']) ? $allDefaultsDetails['label'] : '')));
        $defaultValues['detail']['bill_type_default_id'] =
            isset($settingDetails['bill_type_default_id']) ? $settingDetails['bill_type_default_id'] : (isset($allSettingDetails['bill_type_default_id']) ? $allSettingDetails['bill_type_default_id'] : (isset($defaultDetails['bill_type_default_id']) ? $defaultDetails['bill_type_default_id'] : (isset($allDefaultsDetails['bill_type_default_id']) ? $allDefaultsDetails['bill_type_default_id'] : '')));
        $defaultValues['detail']['bill_type_user_setting_id'] =
            isset($settingDetails['bill_type_user_setting_id']) ? $settingDetails['bill_type_user_setting_id'] : (isset($allSettingDetails['bill_type_user_setting_id']) ? $allSettingDetails['bill_type_user_setting_id'] : (isset($defaultDetails['bill_type_user_setting_id']) ? $defaultDetails['bill_type_user_setting_id'] : (isset($allDefaultsDetails['bill_type_user_setting_id']) ? $allDefaultsDetails['bill_type_user_setting_id'] : '')));
        $defaultValues['detail']['account_id'] =
            isset($settingDetails['account_id']) ? $settingDetails['account_id'] : (isset($allSettingDetails['account_id']) ? $allSettingDetails['account_id'] : (isset($defaultDetails['account_id']) ? $defaultDetails['account_id'] : (isset($allDefaultsDetails['account_id']) ? $allDefaultsDetails['account_id'] : '')));
        $defaultValues['detail']['opposite_account_id'] =
            isset($settingDetails['opposite_account_id']) ? $settingDetails['opposite_account_id'] : (isset($allSettingDetails['opposite_account_id']) ? $allSettingDetails['opposite_account_id'] : (isset($defaultDetails['opposite_account_id']) ? $defaultDetails['opposite_account_id'] : (isset($allDefaultsDetails['opposite_account_id']) ? $allDefaultsDetails['opposite_account_id'] : '')));
        $defaultValues['detail']['payment_type'] =
            isset($settingDetails['payment_type']) ? $settingDetails['payment_type'] : (isset($allSettingDetails['payment_type']) ? $allSettingDetails['payment_type'] : (isset($defaultDetails['payment_type']) ? $defaultDetails['payment_type'] : (isset($allDefaultsDetails['payment_type']) ? $allDefaultsDetails['payment_type'] : '')));

        $billType['setting'] = $defaultValues;
        return $billType;
    }

    public function nameObj($request)
    {
        return $this->model->select(['id', 'name', 'is_active', 'accounting_effect'])->where('bill_section', $request['bill_section'])->orderByRaw("FIELD(is_active,1) DESC")->get()
            ->map(function ($billType) use ($request) {
                if ($billType['accounting_effect'] == 0 || $billType['accounting_effect'] == 1) {
                    $billType['account_flag'] = false;
                } else if ($billType['accounting_effect'] == 2) {
                    $billType['account_flag'] = true;
                    $setting = $billType->billTypeUserSettings()->where('user_id',  $request['user_id'])->first();
                    if (isset($setting)) {
                        $allSettingDetails = $setting->billTypeUserSettingsDetails()->where('payment_type', 1)->first();
                    }

                    $defaults = $billType->billTypeDefaults()->first();
                    if (isset($defaults)) {
                        $allDefaultsDetails = $defaults->billTypeDefaultDetails()->where('payment_type',  1)->first();
                    }
                    $billType['account_id'] =
                        isset($allSettingDetails['account_id']) ? $allSettingDetails['account_id']  : (isset($allDefaultsDetails['account_id']) ? $allDefaultsDetails['account_id'] : '');
                }
                return $billType;
            });
    }
}
