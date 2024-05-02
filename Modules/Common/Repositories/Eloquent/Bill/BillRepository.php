<?php

namespace Modules\Common\Repositories\Eloquent\Bill;

use App\Repositories\Eloquent\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Bills\Bill;
use Modules\Common\Entities\Api\Bills\BillPaymentTerms;
use Modules\Common\Repositories\IRepositories\Bill\IBillRepository;

class BillRepository extends BaseRepository implements IBillRepository
{
    public function model()
    {
        return Bill::class;
    }

    public function createBill($request)
    {
        try {
            DB::beginTransaction();

            $bill = $this->model->create([
                'invoice_total' => $request['invoice_total'],
                'invoice_total_tax' => $request['invoice_total_tax'],
                'bill_type_id' => $request['main']['bill_type_id'],
                'code' => $request['main']['code'],
                'vendor_bill_no' => $request['main']['vendor_bill_no'] ?? null,
                'bill_version' => $request['main']['bill_version'],
                'bill_date' => $request['main']['bill_date'],
                'payment_type' => $request['main']['payment_type'],
                'days_count' => $request['main']['days_count'],
                'currency_id' => $request['main']['currency_id'],
                'conversion_factor' => $request['main']['conversion_factor'] ?? null,
                'notes' => $request['main']['notes'] ?? null,
                'payment_account_id' => $request['main']['payment_account_id'],
                'branch_business_id' => $request['main']['branch_business_id'],
                'bill_account_id' => $request['main']['bill_account_id'],
                'ref_bill_type_id' => $request['main']['ref_bill_type_id'] ?? null,
                'ref_bill_id' => $request['main']['ref_bill_id'] ?? null,
                'supply_date' => $request['main']['supply_date'] ?? null,
                'warehouse_id' => $request['main']['warehouse_id'],
                'cost_center_id' => $request['main']['cost_center_id'] ?? null,
                'representative_id' => $request['main']['representative_id'] ?? null,
                'project_id' => $request['main']['project_id'] ?? null,
                'customer_id' => $request['main']['customer_id'] ?? null,
                'supplier_id' => $request['main']['supplier_id'] ?? null,
                'remarks' => $request['main']['remarks'] ?? null,
                'driver_id' => $request['main']['driver_id'] ?? null,
                'car_id' => $request['main']['car_id'] ?? null,
                'trailer_id' => $request['main']['trailer_id'],
                'shipping_policy_id' => $request['main']['shipping_policy_id'] ?? null,
                'shipping_type' => $request['main']['shipping_type'] ?? null,
                'paid_account_id' => $request['main']['paid_account_id'] ?? null,
                'rest_account_id' => $request['main']['rest_account_id'] ?? null,
                'paid_amount' => $request['main']['paid_amount'] ?? null,
            ]);
            if (!empty($request['bill_effects'])) {
                $this->effectsStore($bill, $request['bill_effects']);
            }
            if (!empty($request['bill_payment_terms'])) {
                $this->paymentTermsStore($bill, $request['bill_payment_terms']);
            }
            $this->itemsStore($bill, $request['bills_items']);
            DB::commit();
            return $bill;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateBill($bill, $request)
    {
        try {
            DB::beginTransaction();

            $bill->update([
                'invoice_total' => $request['invoice_total'],
                'invoice_total_tax' => $request['invoice_total_tax'],
                'bill_type_id' => $request['main']['bill_type_id'],
                'code' => $request['main']['code'],
                'vendor_bill_no' => $request['main']['vendor_bill_no'],
                'bill_version' => $request['main']['bill_version'],
                'bill_date' => $request['main']['bill_date'],
                'payment_type' => $request['main']['payment_type'],
                'days_count' => $request['main']['days_count'],
                'currency_id' => $request['main']['currency_id'],
                'conversion_factor' => $request['main']['conversion_factor'],
                'notes' => $request['main']['notes'],
                'payment_account_id' => $request['main']['payment_account_id'],
                'branch_business_id' => $request['main']['branch_business_id'],
                'bill_account_id' => $request['main']['bill_account_id'],
                'ref_bill_type_id' => $request['main']['ref_bill_type_id'],
                'ref_bill_id' => $request['main']['ref_bill_id'],
                'supply_date' => $request['main']['supply_date'],
                'warehouse_id' => $request['main']['warehouse_id'],
                'cost_center_id' => $request['main']['cost_center_id'],
                'representative_id' => $request['main']['representative_id'],
                'project_id' => $request['main']['project_id'],
                'customer_id' => $request['main']['customer_id'],
                'supplier_id' => $request['main']['supplier_id'],
                'remarks' => $request['main']['remarks'],
                'driver_id' => $request['main']['driver_id'],
                'car_id' => $request['main']['car_id'],
                'trailer_id' => $request['main']['trailer_id'],
                'shipping_policy_id' => $request['main']['shipping_policy_id'],
                'shipping_type' => $request['main']['shipping_type'],
                'paid_account_id' => $request['main']['paid_account_id'],
                'rest_account_id' => $request['main']['rest_account_id'],
                'paid_amount' => $request['main']['paid_amount'],
            ]);
            if (!empty($request['bill_effects'])) {
                $bill->effects()->delete();
                $this->effectsStore($bill, $request['bill_effects']);
            }
            if (!empty($request['bill_effects'])) {
                $bill->paymentTerms()->delete();
                $this->paymentTermsStore($bill, $request['bill_payment_terms']);
            }
            $bill->items()->delete();
            $this->itemsStore($bill, $request['bills_items']);
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    public function paymentTermsStore($bill, $terms)
    {
        foreach ($terms as $term) {
            $bill->paymentTerms()->create([
                'remarks' => $term['remarks'],
                'notes' => $term['notes'],
                'payment_amount' => $term['payment_amount'] ?? null,
                'payment_percent' => $term['payment_percent'] ?? null,
                'payment_date' => $term['payment_date'] ?? null,
            ]);
        }
    }
    public function effectsStore($bill, $effects)
    {
        foreach ($effects as $effect) {
            $bill->effects()->create([
                'remarks' => $effect['remarks'] ?? null,
                'effect_type' => $effect['effect_type'],
                'effect_amount_type' => $effect['effect_amount_type'],
                'effect_value' => $effect['effect_value'],
                'effect_amount' => $effect['effect_amount'],
                'account_id' => $effect['account_id'] ?? null,
                'opposite_account_id' => $effect['opposite_account_id'] ?? null,
                'currency_id' => $effect['currency_id'] ?? null,
                'conversion_factor' => $effect['conversion_factor'] ?? null,
                'reference' => $effect['reference'] ?? null,
                'reference_no' => $effect['reference_no'] ?? null,
            ]);
        }
    }
    public function itemsStore($bill, $items)
    {
        foreach ($items as $item) {
            $createdItem = $bill->items()->create([
                'warehouse_id' => $item['warehouse_id'],
                'product_id' => $item['product_id'],
                'unit_id' => $item['unit_id'],
                'item_desc' => $item['item_desc'] ?? null,
                'add_qty' => $item['add_qty'],
                'converted_add_qty' => $item['converted_add_qty'] ?? null,
                'issue_qty' => $item['issue_qty'] ?? null,
                'converted_issue_qty' => $item['converted_issue_qty'] ?? null,
                'unit_price' => $item['unit_price'] ?? null,
                'total_price' => $item['total_price'] ?? null,
                'total_price_with_tax' => $item['total_price_with_tax'] ?? null,
            ]);
            if (isset($item['bill_items_taxes'])) $this->itemTax($createdItem, $item['bill_items_taxes']);
        }
    }
    public function itemTax($createdItem, $taxes)
    {
        foreach ($taxes as $tax) {
            $tax = $createdItem->taxes()->create([
                'bill_item' => $createdItem['id'],
                'tax_id' => $tax['tax_id'],
                'tax_percent' => $tax['tax_percent'] ?? null,
                'tax_value' => $tax['tax_value'] ?? null,
            ]);
        }
    }

    public function getAllByType($bill_type_id)
    {

        return Bill::with(['items', 'effects', 'paymentTerms'])->where('bill_type_id', $bill_type_id)->get();
    }



    public function warehousesProductBalance($request)
    {
        
        return  itemBalance($request['product_id']);
        // ==============================================================================================================

        // $data = DB::select("SELECT t1.warehouse_id , t1.product_id, IFNULL(tOpening.opening_balance,0) AS opening_balance,IFNULL(tAdd.Add_balance,0) as Add_balance,IFNULL(tIssue.Issue_balance,0) as Issue_balance,(IFNULL(tOpening.opening_balance,0) + IFNULL(tAdd.Add_balance,0) - IFNULL(tIssue.Issue_balance,0) )as Item_balance
        // FROM w_products_warehouses t1 left OUTER JOIN  
        // (SELECT warehouse_id,product_id, SUM(converted_add_qty) AS opening_balance FROM c_bills_items 
        // Where id in (Select id from  bill_effect_balance  Where type_Id = 5)
        // GROUP BY warehouse_id,product_id) tOpening on t1.warehouse_id = tOpening.warehouse_id and t1.product_id = tOpening.product_id 
        // left OUTER JOIN 
        // (SELECT warehouse_id,product_id, SUM(converted_add_qty) AS Add_balance FROM c_bills_items 
        // Where  id in (Select id from bill_effect_balance  Where type_Id  in (2,3) )
        // GROUP BY warehouse_id,product_id) tAdd on t1.warehouse_id = tAdd.warehouse_id and t1.product_id = tAdd.product_id
        // left OUTER JOIN
        // (SELECT warehouse_id,product_id , SUM(converted_issue_qty) AS Issue_balance FROM c_bills_items 
        // Where  id in (Select id from  bill_effect_balance  Where type_Id  in (1,4))
        // GROUP BY warehouse_id,product_id) tIssue on t1.warehouse_id = tIssue.warehouse_id and t1.product_id = tIssue.product_id
        // Where t1.product_id = $request[product_id]
        // Order by t1.warehouse_id ;");
        // return $data;

        // ===========================================================================================================================================
        // $openingBalance =   BillItem::groupBy('warehouse_id')->select(
        //     'warehouse_id',
        //     DB::raw('SUM(converted_add_qty) as add_quantity'),
        //     DB::raw('SUM(converted_issue_qty) as issue_quantity')
        // )
        //     ->where('product_id', $request['product_id'])
        //     ->whereHas('bill', function ($query) {
        //         $query
        //             ->whereHas('BillType', function ($query) {
        //                 $query
        //                     ->where('type_id', 5)
        //                     ->where('stocking_effect', 0);
        //             });
        //     })->get();
        // $inQuantity =   BillItem::groupBy('warehouse_id')->select(
        //     'warehouse_id',
        //     DB::raw('SUM(converted_add_qty) as add_quantity'),
        //     DB::raw('SUM(converted_issue_qty) as issue_quantity')
        // )
        //     ->where('product_id', $request['product_id'])
        //     ->whereHas('bill', function ($query) {
        //         $query
        //             ->whereHas('BillType', function ($query) {
        //                 $query
        //                     ->whereIn('type_id', [2, 3])
        //                     ->where('stocking_effect', 0);
        //             });
        //     })->get();
        // $outQuantity =   BillItem::groupBy('warehouse_id')->select(
        //     'warehouse_id',
        //     DB::raw('SUM(converted_add_qty) as add_quantity'),
        //     DB::raw('SUM(converted_issue_qty) as issue_quantity')
        // )
        //     ->where('product_id', $request['product_id'])
        //     ->whereHas('bill', function ($query) {
        //         $query
        //             ->whereHas('BillType', function ($query) {
        //                 $query
        //                     ->whereIn('type_id', [1, 4])
        //                     ->where('stocking_effect', 0);
        //             });
        //     })->get();


        // return ['opening_balance' => $openingBalance, 'in_quantity' => $inQuantity,  'out_quantity' => $outQuantity];

    }
}
