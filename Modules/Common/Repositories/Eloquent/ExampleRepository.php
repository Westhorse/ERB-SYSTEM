<?php

namespace Modules\Common\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\Example;
use Modules\Common\Repositories\IRepositories\IExampleRepository;

class ExampleRepository extends BaseRepository implements IExampleRepository
{
    public function model()
    {
        return Example::class;
    }
}