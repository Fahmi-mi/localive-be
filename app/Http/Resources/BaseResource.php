<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BaseResource extends JsonResource
{
    /**
     * Return the full translatable object {id, en} for a given field.
     * Falls back to 'id' if the field is missing or not JSON.
     */
    protected function translatable(string $field): array
    {
        $translations = $this->resource->getTranslations($field);

        return [
            'id' => $translations['id'] ?? '',
            'en' => $translations['en'] ?? ($translations['id'] ?? ''),
        ];
    }
}
