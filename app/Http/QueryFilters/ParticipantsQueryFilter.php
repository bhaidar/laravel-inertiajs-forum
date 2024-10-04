<?php

namespace App\Http\QueryFilters;

use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\Filters\Filter;

class ParticipantsQueryFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property)
    {
        if (! auth()->user()) {
            return $query;
        }

        $query
            ->where('user_id', '!=', auth()->id())
            ->whereHas('posts', function ($query) {
                $query->whereBelongsTo(auth()->user());
            });
    }
}
