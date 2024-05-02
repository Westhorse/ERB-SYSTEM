<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Tag;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Tag\Tag;
use Modules\Warehouse\Repositories\IRepositories\Tag\ITagRepository;

class TagRepository extends BaseRepository implements ITagRepository
{
    public function model()
    {
        return Tag::class;
    }

}
