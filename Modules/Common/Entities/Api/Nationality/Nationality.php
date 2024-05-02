<?php

namespace Modules\Common\Entities\Api\Nationality;

use Database\Factories\Nationality\NationalityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;

class Nationality extends BaseModel
{
    use HasFactory;

    protected $table = 'c_nationalities';
    public $translatable = ['name'];
    protected $guarded = [];

    protected static function newFactory()
    {
        return NationalityFactory::new();
    }
}
