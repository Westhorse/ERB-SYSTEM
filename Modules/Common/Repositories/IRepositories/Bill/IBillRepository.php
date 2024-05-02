<?php


namespace Modules\Common\Repositories\IRepositories\Bill;

use App\Repositories\IRepositories\IBaseRepository;

interface IBillRepository extends IBaseRepository
{
     public function createBill($request);

     public function updateBill($bill, $request);

     public function getAllByType($bill_type_id);

     public function warehousesProductBalance($request);
}
