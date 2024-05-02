<?php

namespace Modules\Common\Repositories\Eloquent;

use App\Repositories\Eloquent\BaseRepository;
use Modules\Common\Entities\Api\payment\PaymentType;
use Modules\Common\Repositories\IRepositories\IPaymentTypeRepository;

class PaymentTypeRepository extends BaseRepository implements IPaymentTypeRepository
{
    public function model()
    {
        return PaymentType::class;
    }
}
