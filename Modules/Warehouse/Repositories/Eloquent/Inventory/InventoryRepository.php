<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Inventory;

use App\Repositories\Eloquent\BaseRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\Bills\Bill;
use Modules\Common\Entities\Api\Bills\BillItem;
use Modules\Warehouse\Entities\Api\Inventory\Inventory;
use Modules\Warehouse\Entities\Api\Inventory\InventoryItem;
use Modules\Warehouse\Entities\Api\Product\Product;
use Modules\Warehouse\Repositories\IRepositories\Inventory\IInventoryRepository;

class InventoryRepository extends BaseRepository implements IInventoryRepository
{
    public function model()
    {
        return Inventory::class;
    }

    function itemsStore($inventory, $items)
    {
        foreach ($items as $item) {
            $inventory->items()->create([
                'product_id' => $item['product_id'],
                'product_qty' => $item['product_qty'],
                'remarks' => $item['remarks'] ?? null,
            ]);
        }
    }

    public function listStore($inventory, $list)
    {
        foreach ($list as $item) {
            $inventory->list()->create([
                'src_inventory_id' => $item,
            ]);
        }
    }

    public function createRequest($request)
    {
        try {
            DB::beginTransaction();

            $inventory = $this->model->create([
                'code' => $request['code'],
                'name' => $request['name'],
                'inventory_date' => $request['inventory_date'],
                'warehouse_id' => $request['warehouse_id'],
                'currency_id' => $request['currency_id'],
                'conversion_factor' => $request['conversion_factor'],
                'inventory_type' => $request['inventory_type'],
                'remarks' => $request['remarks'] ?? null,
            ]);

            if ($request['inventory_type'] == 2) {
                $this->listStore($inventory, $request['list']);
            }
            if (!empty($request['items'])) {
                $this->itemsStore($inventory, $request['items']);
            }
            DB::commit();
            return $inventory;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function updateInventory($inventory, $request)
    {
        $inventory->update([
            'code' => $request['code'],
            'name' => $request['name'],
            'inventory_date' => $request['inventory_date'],
            'warehouse_id' => $request['warehouse_id'],
            'currency_id' => $request['currency_id'],
            'conversion_factor' => $request['conversion_factor'],
            'inventory_type' => $request['inventory_type'],
            'remarks' => $request['remarks'] ?? null,
        ]);
    }

    public function savedQuantity($list, $productId)
    {
        return $this->model
            ->whereIn('w_inventories.id', $list)
            ->where('w_inventory_items.product_id', $productId)
            ->where('w_inventory_items.deleted_at', null)
            ->leftJoin('w_inventory_items', 'w_inventories.id', '=', 'w_inventory_items.inventory_id')
            ->select('w_inventory_items.product_id', 'w_inventory_items.product_qty')
            ->sum('w_inventory_items.product_qty');
    }

    public function updateRequest($request, $inventory)
    {
        try {
            if ($inventory['is_approved'] == 1) return false;
            if ($inventory->listInventories()->exists()) return false;
            if ($request['itemsChanged']) {
                foreach ($request['items'] as $item) {
                    if ($this->savedQuantity($request['list'], $item['product_id']) != $item['product_qty']) return false;
                }
            }
            DB::beginTransaction();

            $this->updateInventory($inventory, $request);

            if ($inventory['inventory_type'] == 2) {
                $inventory->list()->delete();
                $this->listStore($inventory, $request['list']);
            };

            $inventory->items()->delete();
            $this->itemsStore($inventory, $request['items']);
           
            DB::commit();

            return true;

        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function names()
    {
        return  $this->model->select(['id', 'name'])->get();
    }

    public function fillteredNames()
    {
        return  $this->model->where('is_approved', 0)->doesntHave('listToBelong')->doesntHave('listInventories')->select(['id', 'name'])->get();
    }

    public function gatherItems($ids)
    {
        return InventoryItem::groupBy('product_id')
            ->whereIn('inventory_id', $ids)
            ->selectRaw('sum(product_qty) as product_qty, inventory_id, product_id, remarks')
            ->get();
    }


    public function deleteRecords($tableName, $ids, $relationsToNeglect = [])
    {
        $databaseName = DB::connection()->getDatabaseName();
        $destroyDenied = [];
        foreach ($ids as $id) {
            $inventory = $this->model->find($id);
            if (checkColumnUsed($databaseName, $tableName, 'id', $id, $relationsToNeglect) || $inventory['is_approved'] == 1 || $inventory->listInventories()->exists()) {
                $destroyDenied[] = [$id];
            } else {
                $this->delete($id);
            }
        }
        return count($destroyDenied);
    }

    public function billCodeGenerator($key = null, $value = null)
    {
        $code = DB::table('c_bills')->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->orderBy('id', 'desc')->pluck('code')->first();
        $nextCode = getAutoGeneratedNextCode($code);
        $newCode =  DB::table('c_bills')->when(isset($value), function ($query) use ($key, $value) {
            return $query->where($key, $value);
        })->where('code', $nextCode)->pluck('code')->first();
        while ($newCode != null) {
            $nextCode = getAutoGeneratedNextCode($newCode);
            $newCode =  DB::table('c_bills')->when(isset($value), function ($query) use ($key, $value) {
                return $query->where($key, $value);
            })->where('code', $nextCode)->pluck('code')->first();
        }
        return $nextCode;
    }
    public function approve($request, $inventory)
    {

        try {
            DB::beginTransaction();
            $inventory->update(['is_approved' => 1]);
            $items =  $inventory->items()->get();
            $inItems = [];
            $outItems = [];
            $productsQuantity = [];
            foreach ($items as $item) {
                $balance = itemBalance($item['product_id'], $inventory['warehouse_id']);
                $balanceOfItem = ($balance['opening_balance'] ?? 0) + ($balance['Add_balance'] ?? 0) - ($balance['Issue_balance'] ?? 0) - $item['product_qty'];
                $productsQuantity[$item['product_id']] = $balanceOfItem;
                if ($balanceOfItem > 0) $inItems[] =  $item['product_id'];
                if ($balanceOfItem < 0) $outItems[] =  $item['product_id'];
            }

            if (!empty($inItems)) {
                $inBill = Bill::create([
                    'code' => $this->billCodeGenerator(),
                    'branch_business_id' => $request['branch_business_id'], //
                    'bill_date' => $request['date'],
                    'warehouse_id' => $inventory['warehouse_id'],
                    'currency_id' => $request['currency_id'], //
                    'payment_account_id ' => $request['in_account_id'] ?? null,
                    'conversion_factor' => 1,
                    'bill_type_id' => $request["in_bill_type_id"],
                ]);

                foreach ($inItems as $item) {
                    $product = Product::where('id', $item)->first();
                    BillItem::create([
                        'bill_id' => $inBill['id'],
                        'warehouse_id' =>  $inventory['warehouse_id'],
                        'product_id' => $product['id'],
                        'unit_id' => $product['unit_id'], //
                        'unit_price' => $product['cost_price'], //
                        'add_qty' => $productsQuantity[$product['id']], //
                        'converted_add_qty' =>  $productsQuantity[$product['id']],
                    ]);
                }
            }

            if (!empty($outItems)) {
                $outBill = Bill::create([
                    'code' => $this->billCodeGenerator(),
                    'branch_business_id' => $request['branch_business_id'], //
                    'bill_date' => $request['date'],
                    'warehouse_id' => $inventory['warehouse_id'],
                    'currency_id' => $request['currency_id'], //
                    'payment_account_id ' => $request['out_account_id'] ?? null,
                    'conversion_factor' => 1,
                    'bill_type_id' => $request["out_bill_type_id"],
                ]);
                foreach ($outItems as $item) {
                    $product = Product::where('id', $item)->first();
                    BillItem::create([
                        'bill_id' => $outBill['id'],
                        'warehouse_id' =>  $inventory['warehouse_id'],
                        'product_id' => $product['id'],
                        'unit_id' => $product['unit_id'], //
                        'unit_price' => $product['cost_price'], //
                        'issue_qty' => $productsQuantity[$product['id']], //
                        'converted_issue_qty' =>  $productsQuantity[$product['id']],
                    ]);
                }
            }

            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
}
