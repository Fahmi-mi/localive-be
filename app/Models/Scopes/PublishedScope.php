<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PublishedScope implements Scope
{
    /**
     * Apply the scope to only return published records.
     */
    public function apply(Builder $builder, Model $model): void
    {
        $builder->where('status', 'published');
    }
}
