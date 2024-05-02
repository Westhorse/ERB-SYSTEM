<?php

namespace Modules\Common\Entities\Api\Translations;

use App\Models\BaseModel;

class Caption extends BaseModel
{
    protected $table = 'c_captions';

    public $translatable = ['value'];
    protected $fillable = [
        'code', 'key', 'value'
    ];

}
