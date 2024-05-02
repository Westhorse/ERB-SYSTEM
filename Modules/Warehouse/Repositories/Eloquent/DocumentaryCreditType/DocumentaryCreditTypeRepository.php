<?php

namespace  Modules\Warehouse\Repositories\Eloquent\DocumentaryCreditType;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\DocumentaryCreditType\DocumentaryCreditType;
use Modules\Warehouse\Repositories\IRepositories\DocumentaryCreditType\IDocumentaryCreditTypeRepository;

class DocumentaryCreditTypeRepository extends BaseRepository implements IDocumentaryCreditTypeRepository
{
    public function model()
    {
        return DocumentaryCreditType::class;
    }
}
