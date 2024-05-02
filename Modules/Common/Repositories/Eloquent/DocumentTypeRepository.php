<?php

namespace Modules\Common\Repositories\Eloquent;

use Modules\Common\Entities\Api\card\DocumentType;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\IDocumentTypeRepository;

class DocumentTypeRepository extends BaseRepository implements IDocumentTypeRepository
{
    public function model()
    {
        return DocumentType::class;
    }
    public function getAllByType($dtype)
    {
      return  DocumentType::where('dtype',$dtype)->get();

    }


}
