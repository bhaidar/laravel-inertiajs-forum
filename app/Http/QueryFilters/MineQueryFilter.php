<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class MineQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        if (! auth()->user()) {
            return $query;
        }

        $query->whereBelongsTo(auth()->user());
    }
}
