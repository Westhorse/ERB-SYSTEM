<?php

namespace Modules\POS\QueryBuilders;

use Illuminate\Database\Eloquent\Builder;

class PointSectionQueryBuilder extends Builder
{
    public function fromPeriodIntersects($from, $id = null): self
    {
        return $this->where('section_from', '<=', $from)->where('section_to', '>=', $from);
    }

    public function toPeriodIntersects($to, $id = null): self
    {
        return $this->where('section_from', '<=', $to)->where('section_to', '>', $to);
    }
}
