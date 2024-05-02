<?php

namespace Modules\Common\Repositories\Eloquent\BillType;

use Modules\Common\Entities\Api\BillType\BillTypeUserSetting;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\BillType\IBillTypeUserSettingRepository;

class BillTypeUserSettingRepository extends BaseRepository implements IBillTypeUserSettingRepository
{
    public function model()
    {
        return BillTypeUserSetting::class;
    }
}
