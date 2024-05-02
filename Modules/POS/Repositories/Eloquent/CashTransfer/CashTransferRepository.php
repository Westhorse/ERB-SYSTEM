<?php

namespace Modules\POS\Repositories\Eloquent\CashTransfer;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\DB;
use Modules\POS\Entities\Api\CashTransfer\CashTransfer;
use Modules\POS\Repositories\IRepositories\CashTransfer\ICashTransferRepository;

class CashTransferRepository extends BaseRepository implements ICashTransferRepository
{
    public function model()
    {
        return CashTransfer::class;
    }

    public function createRequest($request)
    {
        $modelObject = $this->model->create([
            'src_user_id'       => $request['src_user_id'],
            'src_pos_id'        => $request['src_pos_id'],
            'src_period_id'     => $request['src_period_id'],
            'trans_date'        => $request['trans_date'],
            'dest_user_id'      => $request['dest_user_id'],
            'dest_pos_id'       => $request['dest_pos_id'],
            'dest_period_id'    => $request['dest_period_id'],
            'amount_value'      => $request['amount_value'],
            'currency_id'       => $request['currency_id'],
        ]);

        if (isset($request['details'])) {
            foreach ($request['details'] as $detail) {
                $modelObject->cashTransferDetails()->create([
                    'part_id'       => $detail['part_id'],
                    'part_count'    => $detail['part_count'],
                ]);
            }
        }
        return $this->showRecord($modelObject);
    }

    public function updateRequest($cashTransfer, $request)
    {
        $cashTransfer->update([
            'src_user_id'       => $request['src_user_id'],
            'src_pos_id'        => $request['src_pos_id'],
            'src_period_id'     => $request['src_period_id'],
            'trans_date'        => $request['trans_date'],
            'dest_user_id'      => $request['dest_user_id'],
            'dest_pos_id'       => $request['dest_pos_id'],
            'dest_period_id'    => $request['dest_period_id'],
            'amount_value'      => $request['amount_value'],
        ]);


        if (!empty($request['details'])) {
            $deletedIds = $cashTransfer->cashTransferDetails()->pluck('id')->toArray();
            foreach ($request['details'] as $detail) {
                $object =  isset($detail['id']) ? $cashTransfer->cashTransferDetails()->find($detail['id']) : null;
                if (!$object) {
                    $cashTransfer->cashTransferDetails()->create([
                        'part_id'       => $detail['part_id'],
                        'part_count'    => $detail['part_count'],
                    ]);
                } else {
                    $object->update([
                        'part_id'       => $detail['part_id'],
                        'part_count'    => $detail['part_count'],
                    ]);
                    unset($deletedIds[array_search($detail['id'], $deletedIds, true)]);
                }
            };
            $cashTransfer->cashTransferDetails()->whereIn('id', $deletedIds)->delete();
        }
        return true;
    }

    public function showRecord($modelObject)
    {
        $modelObject['detailsWithRate'] = DB::table('pos_cash_transfer')
            ->join('pos_cash_transfer_detail', 'pos_cash_transfer_detail.transfer_id', '=', 'pos_cash_transfer.id')
            ->join('c_currencies_parts', 'c_currencies_parts.id', '=', 'pos_cash_transfer_detail.part_id')
            ->select(
                'pos_cash_transfer_detail.id',
                'pos_cash_transfer_detail.part_id',
                'pos_cash_transfer_detail.part_count',
                'pos_cash_transfer_detail.transfer_id',
                'c_currencies_parts.rate',
                DB::raw('c_currencies_parts.rate * pos_cash_transfer_detail.part_count AS totalRate')
            )
            ->where('pos_cash_transfer.id', $modelObject['id'])
            ->where('pos_cash_transfer_detail.deleted_at', NULL)
            ->get();
        return $modelObject;
    }

    public function fetchAll()
    {

        $cashTransfers = CashTransfer::select('pos_cash_transfer.*', 'UsersOne.name AS sender', 'UsersTwo.name AS receiver')
            ->join('temp_users AS UsersOne', 'src_user_id', '=', 'UsersOne.id')
            ->join('temp_users AS UsersTwo', 'dest_user_id', '=', 'UsersTwo.id')
            ->get();

        return $cashTransfers;
    }
}
