<?php

namespace Modules\Common\Repositories\Eloquent\Languages;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Languages\Language;
use Modules\Common\Repositories\IRepositories\Languages\ILanguageRepository;

class LanguageRepository extends BaseRepository implements ILanguageRepository
{
    public function model()
    {
        return Language::class;
    }
}
