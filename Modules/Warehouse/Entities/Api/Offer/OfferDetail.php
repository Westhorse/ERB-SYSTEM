<?php

namespace  Modules\Warehouse\Entities\Api\Offer;

use App\Models\BaseModel;
use App\Models\Product\Product;
use App\Models\Warehouse\Warehouse;


class OfferDetail extends BaseModel
{
    protected $table = "w_offers_detail";
    public $translatable = [];
    protected $fillable = [
        'offer_id', 'kind', 'product_id', 'warehouse_id', 'required_qty', 'offer_qrt', 'max_offer_qty',
        'item_price', 'discount_percent', 'free_qty',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offer::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
