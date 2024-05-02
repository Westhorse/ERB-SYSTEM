<?php

namespace Modules\Common\Entities\Api\DocumentIssuer;

use App\Models\BaseModel;

class DocumentIssuer extends BaseModel
{

    protected $table = "c_document_issuer";
    public $translatable = ['name'];


    protected $guarded = [ ];

    public function vehicleDocuments()
    {
        return $this->hasMany(VehicleDocument::class);
    }

    public function counts()
    {

        return $this->vehicleDocuments()->count();
    }
}
