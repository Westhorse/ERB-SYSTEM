<?php

namespace Modules\POS\Entities\Api\PointSection;

use App\Models\BaseModel;
use Modules\POS\QueryBuilders\PointSectionQueryBuilder;

class PointSection extends BaseModel
{
    protected $table = "pos_points_sections";
    public $guarded = [];
    public $translatable = [];

    public function newEloquentBuilder($query): PointSectionQueryBuilder
    {
        return new PointSectionQueryBuilder($query);
    }

    // public static function findOrCreate($data)
    // {
       
    //     $recourd = DB::table('pos_points_sections')->where('id',$data['id'])->first();

    //     if (empty($recourd)) {
    //         return PointSection::create($data);
        
    //     } else {
           
    //         $update=$recourd->update($data);
    //         return $x;
    //     }
    // }
}
