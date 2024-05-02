<?php

namespace Modules\Common\Repositories\Eloquent\Translations;

use Modules\Common\Entities\Api\Translations\Message;
use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Repositories\IRepositories\Translations\IMessageRepository;

class MessageRepository extends BaseRepository implements IMessageRepository
{
    public function model()
    {
        return Message::class;
    }

    public function getAllObjects()
    {
        return $this->model->select('key', 'value')->get();
    }
}
