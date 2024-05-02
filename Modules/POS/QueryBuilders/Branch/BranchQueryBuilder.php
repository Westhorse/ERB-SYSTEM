<?php
namespace Modules\POS\QueryBuilders\Branch;

use Illuminate\Database\Eloquent\Builder;

class BranchQueryBuilder extends Builder
{
    public function fromTimePeriodIntersects($fromTime , $id = null): self
    {
        return $this->whereHas('periods', function (Builder $query) use($fromTime, $id) {
            $query->where('id', '!=', $id)->where('from_time', '<=', $fromTime)->where('to_time', '>', $fromTime);
        });
    }

    public function toTimePeriodIntersects($toTime, $id): self
    {
        return $this->whereHas('periods', function (Builder $query) use($toTime, $id) {
            $query->where('id', '!=', $id)->where('from_time', '<', $toTime)->where('to_time', '>=', $toTime);
        });
    }
}
