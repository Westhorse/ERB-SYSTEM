<?php


namespace Modules\Common\Repositories\IRepositories\Currency;

use App\Repositories\IRepositories\IBaseRepository;

interface ICurrencyRepository extends IBaseRepository
{
    public function currencyParts($currencyId);
}
