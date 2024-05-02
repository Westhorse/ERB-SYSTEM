<?php


namespace Modules\Common\Repositories\IRepositories\BillInstallments;

use App\Repositories\IRepositories\IBaseRepository;

interface IBillInstallmentRepository extends IBaseRepository
{
     public function billInstallmentHandling($request);
     public function show($billId);
}
