<?php

namespace Modules\Common\Repositories\Eloquent\LanguageShortcut;

use Modules\Common\Entities\Api\LanguageShortcut\LanguageShortcut;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\LanguageShortcut\ILanguageShortcutRepository;

class LanguageShortcutRepository extends BaseRepository implements ILanguageShortcutRepository
{
    public function model()
    {
        return LanguageShortcut::class;
    }

}
