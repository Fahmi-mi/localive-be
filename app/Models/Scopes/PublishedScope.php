<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class PublishedScope implements Scope
{
    /**
     * Apply the scope to only return published records.
     * Skips filtering when the request is from an authenticated user
     * so the admin dashboard can see all content including drafts.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (auth()->check()) {
            return;
        }

        $builder->where("status", "published");
    }
}
