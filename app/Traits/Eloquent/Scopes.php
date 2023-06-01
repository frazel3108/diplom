<?php

namespace App\Traits\Eloquent;

use Illuminate\Database\Eloquent\Builder;

trait Scopes
{
    public function scopeSafeJoin(Builder $query, string $table): Builder
    {
        $exists = collect($query->getQuery()->joins)
            ->pluck('table')
            ->contains($table);

        if ($exists) {
            return $query;
        }

        return call_user_func_array(
            [$query, 'join'],
            array_slice(func_get_args(), 1)
        );
    }

    public function scopeSafeLeftJoin(Builder $query, string $table): Builder
    {
        $exists = collect($query->getQuery()->joins)
            ->pluck('table')
            ->contains($table);

        if ($exists) {
            return $query;
        }

        return call_user_func_array(
            [$query, 'leftJoin'],
            array_slice(func_get_args(), 1)
        );
    }
}