<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Offer;

use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Offer\Offer;
use Modules\Warehouse\Repositories\IRepositories\Offer\IOfferRepository;

class OfferRepository extends BaseRepository implements IOfferRepository
{
    public function model()
    {
        return Offer::class;
    }

}
