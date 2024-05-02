<?php

namespace Modules\Common\Entities\Api\card;

use App\Models\BaseModel;

class DocumentType extends BaseModel
{
    public $guarded = ['id'];
    protected $table ='c_document_types';
    public $translatable = ['name'];

    // public function VehicleWheel()
    // {
    //     return $this->hasMany(VehicleWheel::class, 'vehicle_id');
    // }
    // public function counts ()
    // {
    //     return $this->VehicleWheel()->count();
    // }
}
