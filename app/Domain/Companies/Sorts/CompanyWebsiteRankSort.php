<?php

namespace DDD\Domain\Companies\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CompanyWebsiteRankSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->leftJoin('websites', 'websites.id', '=', 'companies.website_id')
              ->orderBy('websites.rank', $descending ? 'desc' : 'asc');
    }
}