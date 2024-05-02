<?php

namespace Modules\POS\Entities\Api\Member;

use App\Models\BaseModel;
use Database\Factories\Member\MemberFactory;

class Member extends BaseModel
{
    protected $table = "pos_members";
    public $translatable = ['name','work_field','address']; 
    protected $fillable = [
        'code', 'name', 'is_active','work_field','telephone','mobile','email','address','nationality_id'
    ];

    protected static function newFactory()
    {
        return MemberFactory::new();
    }

}
