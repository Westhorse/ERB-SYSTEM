<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Customer;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Customer\Customer;
use Modules\Warehouse\Repositories\IRepositories\Customer\ICustomerRepository;


class CustomerRepository extends BaseRepository implements ICustomerRepository
{
    public function model()
    {
        return Customer::class;
    }

}
