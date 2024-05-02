<?php

namespace Modules\POS\Repositories\IRepositories\CashTransfer;

use App\Repositories\IRepositories\IBaseRepository;

interface ICashTransferRepository extends IBaseRepository
{
    public function createRequest($request);
    public function updateRequest($cashTransfer, $request);
    public function fetchAll();
    public function showRecord($modelObject);
}
