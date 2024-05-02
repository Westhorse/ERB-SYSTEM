<?php

namespace Modules\Common\Entities\Api\LanguageShortcut;

use App\Models\BaseModel;

class LanguageShortcut extends BaseModel
{
    public $translatable = [];
    protected $guarded = [];
    protected $table    = 'c_languages_shortcuts';
}
