<?php

namespace Modules\Common\Entities\Api\Vehicle;

use App\Models\BaseModel;
use Modules\Common\Entities\Api\card\DocumentType;

class VehicleDocument extends BaseModel
{

    protected $table = 'c_vehicle_documents';

    public $translatable =[];
    protected $fillable = ["doc_serial", "start_date", "end_date", "notes", "value", "document_type_id", "document_issuer_id", "vehicle_data_id"];

    public function documentIssuer()
    {
        return $this->belongsTo(DocumentIssuer::class, 'document_issuer_id');
    }

    public function documentType()
    {
        return $this->belongsTo(DocumentType::class, 'document_type_id');
    }
}
