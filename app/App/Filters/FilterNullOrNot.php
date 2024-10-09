<?php

namespace DDD\App\Filters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class FilterNullOrNot implements Filter
{
    public function __invoke(Builder $query, $value, string $property)
    {
        if ($value === 'null') {
            $query->whereNull($property);
        } elseif ($value === 'not_null') {
            $query->whereNotNull($property);
        }
    }
}
