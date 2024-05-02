<?php

namespace Modules\Common\Entities\Api\Languages;

use App\Models\BaseModel;

class Language extends BaseModel
{
    protected $table = 'c_languages';

    public $translatable = ['name'];
    protected $fillable = [
        'code', 'name', 'key','is_active'
    ];
}
