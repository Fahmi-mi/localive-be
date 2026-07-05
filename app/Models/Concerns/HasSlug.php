<?php

namespace App\Models\Concerns;

use Spatie\Sluggable\HasSlug as SpatieHasSlug;
use Spatie\Sluggable\SlugOptions;

trait HasSlug
{
    use SpatieHasSlug;

    /**
     * Get the options for generating the slug.
     * Override this in each model to customize the source field.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom($this->sluggableSource())
            ->saveSlugsTo('slug');
    }

    /**
     * Return the source field for slug generation.
     * Default: 'title.id' (Indonesian title from JSON column).
     * Override per model if the translatable field name differs.
     */
    protected function sluggableSource(): string
    {
        return "title->id";
    }
}
