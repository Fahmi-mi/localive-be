<?php

namespace App\Models\Concerns;

use App\Models\Scopes\PublishedScope;

trait HasPublished
{
    /**
     * Boot the trait: auto-apply global PublishedScope.
     */
    public static function bootHasPublished(): void
    {
        static::addGlobalScope(new PublishedScope());
    }

    /**
     * Check if the record is currently published.
     */
    public function isPublished(): bool
    {
        return $this->status === 'published';
    }

    /**
     * Check if the record is a draft.
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }
}
