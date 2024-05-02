<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillTypeUserSettingDetail;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeUserSettingDetailRepository;

class BillTypeUserSettingDetailRepository extends BaseRepository implements IBillTypeUserSettingDetailRepository
{
    public function model()
    {
        return BillTypeUserSettingDetail::class;
    }
}
