<?php


namespace Modules\Common\Repositories\IRepositories\BillType;

use App\Repositories\IRepositories\IBaseRepository;

interface IBillTypeRepository extends IBaseRepository
{
    public function createRequest($request);

    public function updateRequest($billType, $request);

    public function namesByType($type_id);
    
    public function getBillTypeSetting($billType , $request);

    public function nameObj($request);
}
