<?php

namespace Modules\POS\Repositories\Eloquent\Member;

use App\Repositories\Eloquent\BaseRepository;
use Modules\POS\Entities\Api\Member\Member;
use Modules\POS\Repositories\IRepositories\Member\IMemberRepository;

class MemberRepository extends BaseRepository implements IMemberRepository
{
    public function model()
    {
        return Member::class;
    }
}
