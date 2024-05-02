<?php

namespace Modules\POS\Repositories\Eloquent\Cashier;

use App\Repositories\Eloquent\BaseRepository;
use Modules\POS\Entities\Api\Cashier\Cashier;
use Modules\POS\Repositories\IRepositories\Cashier\ICashierRepository;

class CashierRepository extends BaseRepository implements ICashierRepository
{
    public function model()
    {
        return Cashier::class;
    }
}
