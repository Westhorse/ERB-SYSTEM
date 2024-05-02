<?php

namespace Modules\Common\Repositories\Eloquent\Translations;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Translations\Caption;
use Modules\Common\Repositories\IRepositories\Translations\ICaptionRepository;

class CaptionRepository extends BaseRepository implements ICaptionRepository
{
    public function model()
    {
        return Caption::class;
    }

    public function fetchKeys()
    {
        return $this->model->whereIn('key', ['nav_bar', 'side_bar', 'pages', 'footer'])->orwhere('key', 'like',  'bill-type-%')->get();
    }

    public function fetchByCode($code)
    {
        return $this->model->where('code', $code)->get();
    }
    public function getAllObjects()
    {
        return $this->model->select('code', 'key', 'value')->get();
    }
}
