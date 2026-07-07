<?php

namespace App\Models\Concerns;

use Spatie\Translatable\HasTranslations;

trait HasTranslatableFields
{
    use HasTranslations;

    public static function bootHasTranslatableFields(): void
    {
        // Fallback locale is read from config('translatable.fallback_locale')
        // which defaults to app fallback locale if not explicitly set.
    }
}
