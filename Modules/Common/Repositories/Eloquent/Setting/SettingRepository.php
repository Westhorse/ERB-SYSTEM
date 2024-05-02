<?php

namespace Modules\Common\Repositories\Eloquent\Setting;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Setting\Setting;
use Modules\Common\Repositories\IRepositories\Setting\ISettingRepository;

class SettingRepository extends BaseRepository implements ISettingRepository
{
    public function model()
    {
        return Setting::class;
    }

    

}