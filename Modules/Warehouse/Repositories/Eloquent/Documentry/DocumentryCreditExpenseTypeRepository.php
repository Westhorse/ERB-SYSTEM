<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Documentry;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Documentry\DocumentryCreditExpenseType;
use Modules\Warehouse\Repositories\IRepositories\Documentry\IDocumentryCreditExpenseTypeRepository;

class DocumentryCreditExpenseTypeRepository extends BaseRepository implements IDocumentryCreditExpenseTypeRepository
{
    public function model()
    {
        return DocumentryCreditExpenseType::class;
    }
}
