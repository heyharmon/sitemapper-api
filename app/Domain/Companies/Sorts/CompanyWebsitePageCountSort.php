<?php

namespace DDD\Domain\Companies\Sorts;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Sorts\Sort;

class CompanyWebsitePageCountSort implements Sort
{
    public function __invoke(Builder $query, bool $descending, string $property)
    {
        $query->leftJoin('websites', 'websites.id', '=', 'companies.website_id')
              ->orderBy('websites.page_count', $descending ? 'desc' : 'asc');
    }
}