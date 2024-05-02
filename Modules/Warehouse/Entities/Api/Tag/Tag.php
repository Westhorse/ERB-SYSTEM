<?php

namespace  Modules\Warehouse\Entities\Api\Tag;

use Database\Factories\Tag\TagFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\BaseModel;


class Tag extends BaseModel
{
    use HasFactory;
    protected $table = 'w_tags';
    public $translatable = ['name'];
    protected $fillable = [
        'name',
        'code',
        'is_active'
    ];

    protected static function newFactory()
    {
        return TagFactory::new();
    }
}
