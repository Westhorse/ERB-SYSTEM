<?php

namespace  Modules\Warehouse\Entities\Api\Product;

use App\Models\BaseModel;

class Determinant extends BaseModel
{
    protected $table = "w_determinants";

    public $guarded = ['id'];
    protected $with= ['determinantsDetail'];
    public $translatable = ['name'];

    public function determinantsDetail()
    {
        return $this->hasMany(DeterminantsDetail::class);
    }
}
