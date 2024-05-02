<?php


namespace Modules\Warehouse\Repositories\IRepositories\TransferItemsVoucher;

use App\Repositories\IRepositories\IBaseRepository;

interface ITransferItemsVoucherRepository extends IBaseRepository
{
    public function createRequest($request);
    public function updateRequest($transferVoucher, $request);
}
