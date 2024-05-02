<?php

namespace Modules\Common\Repositories\Eloquent\BillInstallments;

use App\Repositories\Eloquent\BaseRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Modules\Common\Entities\Api\BillInstallments\BillInstallment;
use Modules\Common\Repositories\IRepositories\BillInstallments\IBillInstallmentRepository;

class BillInstallmentRepository extends BaseRepository implements IBillInstallmentRepository
{
    public function model()
    {
        return BillInstallment::class;
    }
    public function detailsStore($installment, $details)
    {
        foreach ($details as $detail) {
            $installment->details()->create([
                'installment_date' => $detail['installment_date'],
                'installment_value' => $detail['installment_value'],
                'installment_status' => $detail['installment_status'],
                'remarks' => $detail['remarks'] ?? null,
            ]);
        }
    }
    public function billInstallmentHandling($request)
    {
        try {
            DB::beginTransaction();
            $billInstallment = $this->model->where('bill_id', $request['bill_id'])->first();
            $payload = [
                'bill_id' => $request['bill_id'],
                'installment_way' => $request['installment_way'],
                'period_start' => $request['period_start'],
                'calc_by_hijri' => $request['calc_by_hijri'],
                'first_payment' => $request['first_payment'],
                'first_payment_date' => $request['first_payment_date'],
                'start_date' => $request['start_date'],
                'installment_value' => $request['installment_value'],
                'installment_count' => $request['installment_count'],
            ];
            if (!empty($billInstallment)) {
                $paid = $billInstallment->details()->where('installment_status', 1)->count();
                if ($paid > 0) {
                    return 'paid';
                }
                $billInstallment->update($payload);
                $billInstallment->details()->delete();
            } else {
                $billInstallment = $this->model->create($payload);
            }
            if (!empty($request['details'])) {
                $this->detailsStore($billInstallment, $request['details']);
            }
            DB::commit();
            return $billInstallment;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function show($billId)
    {
        $installment = $this->model->where("bill_id", $billId)->with('details')->first();
        if ($installment) {
            return  $installment;
        }
        return false;
    }
}
