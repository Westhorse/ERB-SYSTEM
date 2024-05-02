<?php

namespace Modules\Common\Repositories\Eloquent;


use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\DocumentIssuer\DocumentIssuer;
use Modules\Common\Repositories\IRepositories\IDocumentIssuerRepository;

class DocumentIssuerRepository extends BaseRepository implements IDocumentIssuerRepository
{
    public function model()
    {
        return DocumentIssuer::class;
    }
}
