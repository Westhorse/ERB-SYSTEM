<?php

namespace  Modules\Warehouse\Repositories\Eloquent\Offer;

;
use App\Repositories\Eloquent\BaseRepository;
use  Modules\Warehouse\Entities\Api\Offer\OfferDetail;
use Modules\Warehouse\Repositories\IRepositories\Offer\IOfferDetailRepository;

class OfferDetailRepository extends BaseRepository implements IOfferDetailRepository
{
    public function model()
    {
        return OfferDetail::class;
    }

}
