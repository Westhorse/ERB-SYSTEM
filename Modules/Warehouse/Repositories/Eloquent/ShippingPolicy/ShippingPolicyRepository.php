<?php

namespace  Modules\Warehouse\Repositories\Eloquent\ShippingPolicy;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\ShippingPolicy\ShippingPolicy;
use Modules\Warehouse\Repositories\IRepositories\ShippingPolicy\IShippingPolicyRepository;

class ShippingPolicyRepository extends BaseRepository implements IShippingPolicyRepository
{
    public function model()
    {
        return ShippingPolicy::class;
    }

}
