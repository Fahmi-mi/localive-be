<?php

namespace App\Models\Concerns;

use Spatie\Translatable\HasTranslations;

trait HasTranslatableFields
{
    use HasTranslations;

    /**
     * Boot the trait: configure fallback locale to Indonesian.
     */
    public static function bootHasTranslatableFields(): void
    {
        // Fallback locale is read from config('translatable.fallback_locale')
        // which defaults to app fallback locale if not explicitly set.
    }

    /**
     * Override to use our custom fallback logic if needed.
     */
    public function getTranslation(string $key, string $locale, bool $useFallbackLocale = true): mixed
    {
        return parent::getTranslation($key, $locale, $useFallbackLocale);
    }
}
