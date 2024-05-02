<?php

namespace Modules\POS\Repositories\Eloquent\PointSection;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Setting\Setting;
use Modules\POS\Entities\Api\PointSection\PointSection;
use Modules\POS\Repositories\IRepositories\IPointSection\IPointSectionRepository;

class PointSectionRepository extends BaseRepository implements IPointSectionRepository
{
    public function model()
    {
        return PointSection::class;
    }

    public function getPointSectionsAndSettingValue()
    {
        $pointSections = PointSection::get(['id', 'section_from', 'section_to', 'point_value']);
        $settingValue  = Setting::select('setting_value')->where('setting_id', 4001)->first();
        return ['value' => $pointSections, 'setting' => $settingValue];
    }
}
