<?php

namespace  Modules\Warehouse\Entities\Api\Image;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable = [
        'image',
        'imageable_id',
        'imageable_type',
        'type',
        'size'
    ];


    public function imageable()
    {
        return $this->morphTo();
    }


    public function getImageAttribute($value)
    {
        return (!empty($value)) ? asset('storage/' . $value) : '';
    }//end of get image path
}
