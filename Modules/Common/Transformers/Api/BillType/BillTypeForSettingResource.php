<?php

namespace Modules\Common\Transformers\Api\BillType;

use Illuminate\Http\Resources\Json\JsonResource;

class BillTypeForSettingResource extends JsonResource
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
            'branch_id' => $this->branch_id,
            'group_id' => $this->group_id,
            'type_id' => $this->type_id,
            
            'accountsObject' => $request->header('index') == true ? '' : [
                'discount_account_id' => $this->discount_account_id,
                'add_account_id' => $this->add_account_id,
                'rest_amount_account_id' => $this->rest_amount_account_id,
                'paid_account_id' => $this->paid_account_id,
            ],
            // خصائص أساسية
            'mainInfoObject' => $request->header('index') == true ? '' : [
                'cost_price_effect' => $this->cost_price_effect,
                'discount_cost_price_effect' => $this->discount_cost_price_effect,
                'add_cost_price_effect' => $this->add_cost_price_effect,
                'accounting_effect' => $this->accounting_effect,
                'bill_section' => $this->bill_section,
                'account_balance' => $this->account_balance,
            ],

            //خيارات إضافية
            'additionalOptionsObject' => $request->header('index') == true ? '' : [
                'time_limit' => $this->time_limit,
                'payment_voucher_id' => $this->payment_voucher_id,
                'currency_id' => $this->currency_id,
                'cost_center_type' => $this->cost_center_type,
                'edit_item_qty' => $this->edit_item_qty,
                'calculate_compound_price' => $this->calculate_compound_price,
                'discount_qty_as_percent' => $this->discount_qty_as_percent,
                'add_qty_as_percent' => $this->add_qty_as_percent,
                'payment_terms_with_net_invoice' => $this->payment_terms_with_net_invoice,
                'open_drawer_with_add' => $this->open_drawer_with_add,
                'max_item_qty' => $this->max_item_qty,
                'use_default_warehouse' => $this->use_default_warehouse,
                'generate_voucher_to_warehouse' => $this->generate_voucher_to_warehouse,
                'accumulated_bill_type_id' => $this->accumulated_bill_type_id,
                'change_bill_type_id' => $this->change_bill_type_id,
                'offer_id' => $this->offer_id,
            ],
            //الضريبة
            'taxes' => $request->header('index') == true ? '' : [
                'tax_exemption' => $this->tax_exemption,
                'manual_tax_entry' => $this->manual_tax_entry,
                'tax_base' => $this->tax_base,
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
            'settings' => isset($this->setting) ? new BillTypeSettingsResource($this->setting) : '',
        ];
    }
}
