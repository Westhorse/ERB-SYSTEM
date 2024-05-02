<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeResource extends JsonResource
{

    public static $wrap = 'data';

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $nameTrans = $this->translations['name'];
        $key = fetchLangFromInputFields($nameTrans);
        return [
            'id' => $this->id,
            'name'  => $request->header('index') == true ? $nameTrans[$key] : $nameTrans,
            'group_id' => $this->group_id,
            'type_id' => $this->type_id,

            'accountsObject' => $request->header('index') == true ? '' : [
                'cost_account_id' => $this->cost_account_id,
                'stock_account_id' => $this->stock_account_id,
                'donate_account_id' => $this->donate_account_id,
                'discount_account_id' => $this->discount_account_id,
                'add_account_id' => $this->add_account_id,
                'rest_amount_account_id' => $this->rest_amount_account_id,
                'paid_account_id' => $this->paid_account_id,
            ],
            // خصائص أساسية
            'mainInfoObject' => $request->header('index') == true ? '' : [
                'branch_id' => $this->branch_id,
                'stocking_effect' => $this->stocking_effect,
                'cost_price_effect' => $this->cost_price_effect,
                'discount_cost_price_effect' => $this->discount_cost_price_effect,
                'add_cost_price_effect' => $this->add_cost_price_effect,
                'distribution_type' => $this->distribution_type,
                'accounting_effect' => $this->accounting_effect,
                'automatic_accounting_posting' => $this->automatic_accounting_posting,
                'bill_section' => (string) $this->bill_section,
                'compound_Journal' => $this->compound_Journal,
                'sum_debit_acc' => $this->sum_debit_acc,
                'sum_credit_acc' => $this->sum_credit_acc,
                'load_generated_journal' => $this->load_generated_journal,
                'exchange_expenses_income_acc' => $this->exchange_expenses_income_acc,
                'exchange_product_stock_acc' => $this->exchange_product_stock_acc,
                'post_bill_cost' => $this->post_bill_cost,
                'account_balance' => $this->account_balance,
                'automatic_save_bill' => $this->automatic_save_bill,
                'allow_selling_non_entry_serial' => $this->allow_selling_non_entry_serial,
                'random_serials' => $this->random_serials,
                'ignore_product_add_discount' => $this->ignore_product_add_discount,
                'cost_center_mandatory' => $this->cost_center_mandatory,
                'representative_mandatory' => $this->representative_mandatory,
                'multi_version' => $this->multi_version,
                'code_per_user' => $this->code_per_user,
            ],

            //خيارات إضافية
            'additionalOptionsObject' => $request->header('index') == true ? '' : [
                'time_limit' => $this->time_limit,
                'payment_voucher_id' => $this->payment_voucher_id,
                'currency_id' => $this->currency_id,
                'cost_center_type' => $this->cost_center_type,
                'qty_approximation_digits' =>  $this->qty_approximation_digits,
                'amount_approximation_digits' => $this->amount_approximation_digits,
                'barcode_search' => $this->barcode_search,
                'output_oldest_expire_date' => $this->output_oldest_expire_date,
                'output_expire_date_purchase_date' => $this->output_expire_date_purchase_date,
                'expire_date_purchase_discount' => $this->expire_date_purchase_discount,
                'edit_item_qty' => $this->edit_item_qty,
                'update_query' => $this->update_query,
                'product_category_filter' => $this->product_category_filter,
                'contact_filter_by_company' => $this->contact_filter_by_company,
                'use_smpile_bill' => $this->use_smpile_bill,
                'calculate_compound_price' => $this->calculate_compound_price,
                'consider_payment_value_in_Bill_paid' => $this->consider_payment_value_in_Bill_paid,
                'use_price_from_last_offer' => $this->use_price_from_last_offer,
                'use_price_list' => $this->use_price_list,
                'discount_qty_as_percent' => $this->discount_qty_as_percent,
                'add_qty_as_percent' => $this->add_qty_as_percent,
                'payment_terms_with_net_invoice' => $this->payment_terms_with_net_invoice,
                'open_drawer_with_add' => $this->open_drawer_with_add,
                'pirce_modification_with_total_modification' => $this->pirce_modification_with_total_modification,
                'connect_with_customs_transaction' => $this->connect_with_customs_transaction,
                'max_item_qty' => $this->max_item_qty,
                'company_filter_acc' => $this->company_filter_acc,
                'use_touch_screen' => $this->use_touch_screen,
                'connect_with_employee_vehicle' => $this->connect_with_employee_vehicle,
                'modify_vehicle_weight' => $this->modify_vehicle_weight,
                'use_default_warehouse' => $this->use_default_warehouse,
                'generate_voucher_to_warehouse' => $this->generate_voucher_to_warehouse,
                'normal_price_color' => $this->normal_price_color,
                'min_cost_price_color' => $this->min_cost_price_color,
                'min_sell_price_color' => $this->min_sell_price_color,
                'negative_qty_color' => $this->negative_qty_color,
                'exceed_min_limit_color' => $this->exceed_min_limit_color,
                'exceed_max_limit_color' => $this->exceed_max_limit_color,
                'exceed_zero_qty_color' => $this->exceed_zero_qty_color,
                'price_from_offers_color' => $this->price_from_offers_color,
                'accumulated_bill_type_id' => $this->accumulated_bill_type_id,
                'change_bill_type_id' => $this->change_bill_type_id,
                'offer_id' => $this->offer_id,
            ],
            //الضريبة
            'taxes' => $request->header('index') == true ? '' : [
                'tax_exemption' => $this->tax_exemption,
                'manual_tax_entry' => $this->manual_tax_entry,
                'tax_base' => $this->tax_base,
                'taxes' => $this->taxesIds(),
            ],
            //فاتورة المناقلة
            'transferItemsInvoiceObject' => $request->header('index') == true ? '' : [
                'generate_transfer_bill' => $this->generate_transfer_bill,
                'show_transfer_bill' => $this->show_transfer_bill,
                'transfer_price' => $this->transfer_price,
                'transfer_branch_id' => $this->transfer_branch_id,
                'in_bill_type_id' => $this->in_bill_type_id,
                'out_bill_type_id' => $this->out_bill_type_id,
                'transfer_warehouse_id' => $this->transfer_warehouse_id,
            ],
            //المراجع
            'referencesObject' => $request->header('index') == true ? '' : [
                'hide_closed_ref' => $this->hide_closed_ref,
                'confirm_ref' => $this->confirm_ref,
                'default_ref' => $this->default_ref,
                'choose_customer_before_ref' => $this->choose_customer_before_ref,
                'delete_bill_ref' => $this->delete_bill_ref,
                'update_prices_from_bill_prices' => $this->update_prices_from_bill_prices,
                'add_to_exist_items' => $this->add_to_exist_items,
                'hide_services_items' => $this->hide_services_items,
                'automatic_load_items' => $this->automatic_load_items,
                'apply_ref_discount' => $this->apply_ref_discount,
                'apply_ref_qty_discount' => $this->apply_ref_qty_discount,
                'show_ref_of_ref' => $this->show_ref_of_ref,
                'show_ref_number' => $this->show_ref_number,
                'choose_multi_ref' => $this->choose_multi_ref,
                'save_ref_number' => $this->save_ref_number,
                'add_ref_info' => $this->add_ref_info,
                'update_expire_date' => $this->update_expire_date,
                'get_bill_ref' => $this->get_bill_ref,
                'get_remakrs' => $this->get_remakrs,
                'get_payment_conditions' => $this->get_payment_conditions,
                'get_table_warehouse' => $this->get_table_warehouse,
                'get_add_discount' => $this->get_add_discount,
                'get_ref_voucher' => $this->get_ref_voucher,
                'get_voucher_values_without_tax' => $this->get_voucher_values_without_tax,
                'get_cost_centers' => $this->get_cost_centers,
                'get_main_warehouse' => $this->get_main_warehouse,
                'get_payment_way' => $this->get_payment_way,
                'get_ref_branch' => $this->get_ref_branch,
                'get_table_remarks' => $this->get_table_remarks,
                'get_account' => $this->get_account,
                'get_bill_ref_number' => $this->get_bill_ref_number,
                'get_time_limit' => $this->get_time_limit,
                'search_in_ref_items' => $this->search_in_ref_items,
                'search_in_opened_ref_items' => $this->search_in_opened_ref_items,
                'get_additional_data' => $this->get_additional_data,
                'get_additional_fields' => $this->get_additional_fields,
                'recalculate_tax' => $this->recalculate_tax,
                'determinants_replacement' => $this->determinants_replacement,
            ],
            'billTypeDefault' => $request->header('index') == true ? '' : new BillTypeDefaultResource($this->billTypeDefaults),
            // 'billTypeUser' => $request->header('index') == true ? '' : BillTypeUserSettingResource::collection($this->billTypeUserSettings),
            'pivotData'    => $request->header('index') == true ? '' : $this->taxes->map->pivot,

            //TODO:temp users
            'users'    => $request->header('index') == true ? '' : $this->users,
            // 'created_at'    => $request->header('index') == true ? '' : $this->created_at->format('d/m/y'), 
        ];
    }
}
