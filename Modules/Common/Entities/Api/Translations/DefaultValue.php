<?php

namespace Modules\Common\Entities\Api\Translations;

use App\Models\BaseModel;

class DefaultValue extends BaseModel
{
    protected $table = 'c_default_values';

    public $translatable = ['label'];
    protected $fillable = [
        'code', 'value', 'label'
    ];

}
