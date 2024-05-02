<?php

namespace Modules\Common\Entities\Api\Translations;

use App\Models\BaseModel;

class Message extends BaseModel
{
    protected $table = 'c_messages';

    public $translatable = ['value'];
    protected $fillable = [
        'code', 'key', 'value'
    ];
}
