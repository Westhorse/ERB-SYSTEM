<?php

namespace Modules\Common\Repositories\Eloquent\Currency;

use App\Repositories\Eloquent\BaseRepository;
use Exception;
use Modules\Common\Entities\Api\Currency\Currency;
use Modules\Common\Entities\Api\Currency\CurrencyPart;
use Modules\Common\Repositories\IRepositories\Currency\ICurrencyRepository;

class CurrencyRepository extends BaseRepository implements ICurrencyRepository
{
    public function model()
    {
        return Currency::class;
    }

    public function currencyParts($currencyId)
    {
        $currencyParts = CurrencyPart::select(['id', 'name', 'rate', 'is_active'])
            ->where('currency_id', $currencyId)->orderByRaw("FIELD(is_active,1) DESC")->get();
        return $currencyParts;
    }
}
